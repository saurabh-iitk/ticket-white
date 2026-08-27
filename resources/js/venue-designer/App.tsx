import React, { useState, useEffect, useRef } from 'react';
import axios from 'axios';
import {
  PricingCategory, Section, Seat, Gate, CanvasState
} from './types.ts';
import { HistoryManager } from './utils/history.ts';
import Toolbar from './components/Toolbar.tsx';
import CanvasWorkspace from './components/CanvasWorkspace.tsx';
import PropertiesPanel from './components/PropertiesPanel.tsx';
import PricingManager from './components/PricingManager.tsx';
import AutoGeneratorDialog from './components/AutoGeneratorDialog.tsx';
import CustomizeToolboxDialog from './components/CustomizeToolboxDialog.tsx';
import {
  Undo, Redo, Save, Play, Tag, LayoutGrid, Info, Download, Upload
} from 'lucide-react';

const getBasePath = () => {
  const index = window.location.pathname.indexOf('/layout/designer/');
  return index !== -1 ? window.location.pathname.substring(0, index) : '';
};
const basePath = getBasePath();

interface AppProps {
  layoutId: number;
}

const App: React.FC<AppProps> = ({ layoutId }) => {
  const [layoutName, setLayoutName] = useState<string>('Loading layout...');
  const [sections, setSections] = useState<Section[]>([]);
  const [seats, setSeats] = useState<Seat[]>([]);
  const [gates, setGates] = useState<Gate[]>([]);
  const [pricingCategories, setPricingCategories] = useState<PricingCategory[]>([]);

  // Selection & Tools
  const [activeTool, setActiveTool] = useState<string>('select');
  const [selectedIds, setSelectedIds] = useState<{ id: string | number; type: 'seat' | 'section' | 'gate' }[]>([]);
  const [zoomScale, setZoomScale] = useState<number>(1);
  const [snapToGrid, setSnapToGrid] = useState<boolean>(true);
  const [gridSize, setGridSize] = useState<number>(20);

  // Modals / Overlays
  const [showPricingManager, setShowPricingManager] = useState<boolean>(false);
  const [showGenerator, setShowGenerator] = useState<boolean>(false);
  const [isPreview, setIsPreview] = useState<boolean>(false);
  const [isSaving, setIsSaving] = useState<boolean>(false);
  const [message, setMessage] = useState<{ text: string; type: 'success' | 'error' | 'info' } | null>(null);
  const [focusMode, setFocusMode] = useState<boolean>(() => {
    return localStorage.getItem('designer-focus-mode') === 'true';
  });
  
  const [isCustomizingToolbar, setIsCustomizingToolbar] = useState<boolean>(false);
  const [iconMapping, setIconMapping] = useState<Record<string, string>>(() => {
    const saved = localStorage.getItem('venue-designer-icon-mapping');
    if (saved) {
      try { return JSON.parse(saved); } catch (e) {}
    }
    return {
      select: 'MousePointer2',
      eraser: 'Trash2',
      seat_regular: 'Armchair',
      seat_vip: 'Crown',
      seat_premium: 'Gem',
      seat_accessible: 'Accessibility',
      seat_companion: 'Users',
      seat_blocked: 'Ban',
      stage: 'Mic',
      entrance: 'DoorOpen',
      exit: 'DoorClosed',
      restroom: 'Bath',
      bar: 'Coffee',
      stairs: 'Layers',
      label: 'Type',
      shape: 'Square'
    };
  });

  const handleToggleFocusMode = (checked: boolean) => {
    setFocusMode(checked);
    localStorage.setItem('designer-focus-mode', checked ? 'true' : 'false');
  };

  useEffect(() => {
    if (focusMode) {
      document.body.classList.add('designer-focus-mode');
    } else {
      document.body.classList.remove('designer-focus-mode');
    }
    return () => {
      document.body.classList.remove('designer-focus-mode');
    };
  }, [focusMode]);

  // History Manager
  const historyRef = useRef<HistoryManager>(new HistoryManager());

  // Load Initial Layout Data
  useEffect(() => {
    fetchLayoutData();
    fetchPricingCategories();
  }, [layoutId]);

  const fetchLayoutData = async () => {
    try {
      const res = await axios.get(`${basePath}/layout/designer/${layoutId}/load`);
      const data = res.data;

      setLayoutName(data.layout.layout_name || 'Unnamed Venue');
      setSections(data.sections || []);

      // Parse legacy or saved seat coords
      const loadedSeats = (data.seats || []).map((seat: any) => ({
        id: seat.id,
        row_no: seat.row_no,
        col_no: seat.col_no,
        name: seat.name || '',
        label: seat.label || '',
        seatno: seat.seatno || '',
        section_id: seat.section_id || null,
        seat_type: seat.seat_type || 'REGULAR',
        x: parseFloat(seat.x) || 0,
        y: parseFloat(seat.y) || 0,
        w: parseInt(seat.w) || 32,
        h: parseInt(seat.h) || 32,
        rotation: parseFloat(seat.rotation) || 0,
        is_visible: seat.is_visible === 'YES',
        is_removed: seat.is_removed === 'YES',
        is_damaged: seat.is_damaged === 'YES',
        is_reserved: seat.is_reserved === 'YES',
      }));
      setSeats(loadedSeats);

      // Parse legacy/saved markers
      let parsedGates: Gate[] = [];
      if (data.layout.markers) {
        try {
          const markers = typeof data.layout.markers === 'string'
            ? JSON.parse(data.layout.markers)
            : data.layout.markers;

          if (markers.gates) {
            parsedGates = markers.gates;
          } else if (Array.isArray(markers)) {
            parsedGates = markers; // legacy format
          }
        } catch (e) {
          console.error("Markers parsing failed", e);
        }
      }
      setGates(parsedGates);

      // Initialize History Stack
      const initialState: CanvasState = {
        sections: data.sections || [],
        seats: loadedSeats,
        gates: parsedGates,
        layoutName: data.layout.layout_name || 'Unnamed Venue'
      };
      historyRef.current = new HistoryManager(initialState);

    } catch (e) {
      showStatusMessage('Error loading venue layout designer data', 'error');
    }
  };

  const fetchPricingCategories = async () => {
    try {
      const res = await axios.get(`${basePath}/layout/designer/pricing-categories/list`);
      setPricingCategories(res.data);
    } catch (e) {
      console.error("Error loading pricing tiers", e);
    }
  };

  const showStatusMessage = (text: string, type: 'success' | 'error' | 'info' = 'info') => {
    setMessage({ text, type });
    setTimeout(() => setMessage(null), 5000);
  };

  // Push local state change onto History Stack
  const recordHistory = (newSections: Section[], newSeats: Seat[], newGates: Gate[]) => {
    historyRef.current.push({
      sections: newSections,
      seats: newSeats,
      gates: newGates,
      layoutName
    });
  };

  // Undo / Redo Click Handlers
  const handleUndo = () => {
    const prev = historyRef.current.undo();
    if (prev) {
      setSections(prev.sections);
      setSeats(prev.seats);
      setGates(prev.gates);
    }
  };

  const handleRedo = () => {
    const next = historyRef.current.redo();
    if (next) {
      setSections(next.sections);
      setSeats(next.seats);
      setGates(next.gates);
    }
  };

  const handleExportLayout = () => {
    const layoutData = {
      version: '1.0',
      layout_name: layoutName,
      sections,
      seats,
      gates,
      pricingCategories
    };

    const blob = new Blob([JSON.stringify(layoutData, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `${layoutName.replace(/\s+/g, '_')}_layout.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    showStatusMessage('Layout exported successfully!', 'success');
  };

  const handleImportLayout = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (event) => {
      try {
        const data = JSON.parse(event.target?.result as string);
        if (!data || !Array.isArray(data.sections) || !Array.isArray(data.seats) || !Array.isArray(data.gates)) {
          showStatusMessage('Invalid file format. Must contain sections, seats, and gates.', 'error');
          return;
        }

        if (data.layout_name) {
          setLayoutName(data.layout_name);
        }
        setSections(data.sections);
        setSeats(data.seats);
        setGates(data.gates);
        setSelectedIds([]);
        recordHistory(data.sections, data.seats, data.gates);
        showStatusMessage('Layout imported successfully!', 'success');
      } catch (err) {
        showStatusMessage('Failed to parse layout file.', 'error');
      }
    };
    reader.readAsText(file);
    e.target.value = '';
  };

  // Save changes back to Database
  const handleSave = async (isPublish = false) => {
    setIsSaving(true);
    showStatusMessage('Saving layout details...', 'info');

    // Package gates/markers
    const markers = {
      gates: gates
    };

    const payload = {
      layout_name: layoutName,
      markers: markers,
      sections: sections,
      seats: seats.map(s => ({
        id: typeof s.id === 'string' ? null : s.id, // client-generated vs database ids
        row_no: s.row_no,
        col_no: s.col_no,
        name: s.name,
        label: s.label,
        seatno: s.seatno,
        section_id: s.section_id,
        seat_type: s.seat_type,
        x: s.x,
        y: s.y,
        w: s.w,
        h: s.h,
        rotation: s.rotation,
        is_visible: s.is_visible,
        is_removed: s.is_removed,
        is_damaged: s.is_damaged,
        is_reserved: s.is_reserved
      }))
    };

    try {
      await axios.post(`${basePath}/layout/designer/${layoutId}/save`, payload);
      showStatusMessage('Layout details saved successfully!', 'success');
      if (isPublish) {
        showStatusMessage('Layout published successfully!', 'success');
      }
    } catch (err) {
      showStatusMessage('Error saving layout details', 'error');
    } finally {
      setIsSaving(false);
    }
  };

  // Property Editor Panel callbacks
  const handlePropertyChange = (type: 'seat' | 'section' | 'gate', id: string | number, key: string, value: any) => {
    let nextSections = [...sections];
    let nextSeats = [...seats];
    let nextGates = [...gates];

    if (type === 'section') {
      nextSections = sections.map(sec => {
        if (sec.id === id || sec.client_id === id) {
          return { ...sec, [key]: value };
        }
        return sec;
      });
      setSections(nextSections);
    } else if (type === 'seat') {
      nextSeats = seats.map(s => {
        if (s.id === id) {
          return { ...s, [key]: value };
        }
        return s;
      });
      setSeats(nextSeats);
    } else if (type === 'gate') {
      nextGates = gates.map(g => {
        if (g.id === id) {
          return { ...g, [key]: value };
        }
        return g;
      });
      setGates(nextGates);
    }

    recordHistory(nextSections, nextSeats, nextGates);
  };

  // Bulk Properties update (like pricing categories of selected seats)
  const handleBulkPropertyChange = (key: string, value: any) => {
    if (selectedIds.length === 0) return;

    let nextSections = [...sections];
    let nextSeats = [...seats];
    let nextGates = [...gates];

    selectedIds.forEach(item => {
      if (item.type === 'seat') {
        nextSeats = nextSeats.map(s => s.id === item.id ? { ...s, [key]: value } : s);
      } else if (item.type === 'section') {
        nextSections = nextSections.map(sec => (sec.id === item.id || sec.client_id === item.id) ? { ...sec, [key]: value } : sec);
      } else if (item.type === 'gate') {
        nextGates = nextGates.map(g => g.id === item.id ? { ...g, [key]: value } : g);
      }
    });

    setSections(nextSections);
    setSeats(nextSeats);
    setGates(nextGates);
    if (key === 'is_removed' && value === true) {
      setSelectedIds([]);
    }
    recordHistory(nextSections, nextSeats, nextGates);
  };

  const handleBulkRenameSeats = (prefix: string, startNumber: number, direction: 'left-to-right' | 'right-to-left') => {
    const selectedSeatIds = selectedIds.filter(item => item.type === 'seat').map(item => item.id);
    if (selectedSeatIds.length === 0) return;

    const selectedSeats = seats.filter(s => s.id !== undefined && selectedSeatIds.includes(s.id));

    // Sort: row-by-row (top-to-bottom) and horizontal direction
    selectedSeats.sort((a, b) => {
      const yDiff = a.y - b.y;
      if (Math.abs(yDiff) < 10) {
        return direction === 'right-to-left' ? b.x - a.x : a.x - b.x;
      }
      return yDiff;
    });

    const nextSeats = seats.map(s => {
      const index = selectedSeats.findIndex(selected => selected.id === s.id);
      if (index !== -1) {
        const num = startNumber + index;
        return {
          ...s,
          label: `${prefix}${num}`,
          seatno: `${prefix}${num}`,
          name: s.section_id 
            ? `${sections.find(sec => sec.id === s.section_id)?.name || ''}-${prefix}${num}`
            : `${prefix}${num}`
        };
      }
      return s;
    });

    setSeats(nextSeats);
    recordHistory(sections, nextSeats, gates);
    setMessage({ text: `Bulk renamed ${selectedSeats.length} seats successfully.`, type: 'success' });
    setTimeout(() => setMessage(null), 5000);
  };

  const handleDuplicateSeat = (seatId: string | number, count: number, direction: 'horizontal' | 'vertical', spacing: number) => {
    const templateSeat = seats.find(s => s.id === seatId);
    if (!templateSeat) return;

    const newSeats: Seat[] = [];
    const stepX = direction === 'horizontal' ? (templateSeat.w || 32) + spacing : 0;
    const stepY = direction === 'vertical' ? (templateSeat.h || 32) + spacing : 0;

    for (let i = 1; i <= count; i++) {
      const nextNum = seats.length + i + 1;
      const newSeat: Seat = {
        ...templateSeat,
        id: `seat_${Date.now()}_${i}`,
        name: templateSeat.section_id 
          ? `${sections.find(sec => sec.id === templateSeat.section_id)?.name || ''}-${nextNum}`
          : `Seat ${nextNum}`,
        label: `${nextNum}`,
        seatno: `${nextNum}`,
        x: templateSeat.x + stepX * i,
        y: templateSeat.y + stepY * i,
        is_reserved: false
      };
      newSeats.push(newSeat);
    }

    const nextSeats = [...seats, ...newSeats];
    setSeats(nextSeats);
    recordHistory(sections, nextSeats, gates);
    setMessage({ text: `Duplicated ${count} seats successfully.`, type: 'success' });
    setTimeout(() => setMessage(null), 5000);
  };

  return (
    <div className="d-flex flex-column h-100 bg-white" style={{ minHeight: focusMode ? '100vh' : '90vh', height: focusMode ? '100vh' : 'auto' }}>
      {focusMode && (
        <style>{`
          body.designer-focus-mode .app-header,
          body.designer-focus-mode .app-sidebar,
          body.designer-focus-mode .app-title {
            display: none !important;
          }
          body.designer-focus-mode {
            overflow: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
          }
          body.designer-focus-mode #layout-designer-root {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 999999 !important;
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
          }
        `}</style>
      )}

      {/* Top Navigation Bar */}
      <header className="navbar navbar-expand-lg navbar-dark bg-dark px-3 py-2 text-white border-bottom shadow-sm">
        <div className="container-fluid d-flex align-items-center justify-content-between">
          <div className="d-flex align-items-center text-nowrap">
            <h1 className="h5 mb-0 font-weight-bold text-white d-flex align-items-center text-nowrap">
              <LayoutGrid className="mr-2 text-primary" size={22} />
              Venue Seat Designer
            </h1>
            <span className="mx-2 text-muted">|</span>
            <div className="form-check form-check-inline text-white d-flex align-items-center mb-0" style={{ gap: '6px' }}>
              <input
                className="form-check-input"
                type="checkbox"
                id="designerModeCheckbox"
                checked={focusMode}
                onChange={(e) => handleToggleFocusMode(e.target.checked)}
                style={{ cursor: 'pointer', width: '16px', height: '16px', margin: 0 }}
              />
              <label 
                className="form-check-label small mb-0 font-weight-bold" 
                htmlFor="designerModeCheckbox"
                style={{ cursor: 'pointer', userSelect: 'none' }}
              >
                Focus Mode
              </label>
            </div>
            <span className="mx-2 text-muted">|</span>
            <input
              type="text"
              value={layoutName}
              onChange={(e) => setLayoutName(e.target.value)}
              className="form-control form-control-sm bg-secondary text-white border-0 font-weight-bold"
              style={{ width: '220px' }}
              placeholder="Layout Name"
              disabled={isPreview}
            />
          </div>

          {/* Action Tools */}
          <div className="d-flex align-items-center" style={{ gap: '8px' }}>
            {!isPreview && (
              <>
                <button
                  onClick={handleUndo}
                  disabled={!historyRef.current.canUndo()}
                  className="btn btn-outline-light btn-sm d-flex align-items-center"
                  title="Undo"
                >
                  <Undo size={16} />
                </button>
                <button
                  onClick={handleRedo}
                  disabled={!historyRef.current.canRedo()}
                  className="btn btn-outline-light btn-sm d-flex align-items-center"
                  title="Redo"
                >
                  <Redo size={16} />
                </button>
                <span className="mx-1 text-muted">|</span>
                <button
                  onClick={() => setShowPricingManager(true)}
                  className="btn btn-outline-primary btn-sm d-flex align-items-center"
                  title="Pricing Categories"
                >
                  <Tag size={16} />
                </button>
                <button
                  onClick={() => setShowGenerator(true)}
                  className="btn btn-outline-info btn-sm d-flex align-items-center"
                  title="Auto-Generate Sections"
                >
                  <LayoutGrid size={16} />
                </button>
                <button
                  onClick={handleExportLayout}
                  className="btn btn-outline-info btn-sm d-flex align-items-center"
                  title="Export Layout"
                >
                  <Download size={16} />
                </button>
                <label
                  className="btn btn-outline-info btn-sm d-flex align-items-center mb-0"
                  title="Import Layout"
                  style={{ cursor: 'pointer', padding: '0.25rem 0.5rem' }}
                >
                  <Upload size={16} />
                  <input
                    type="file"
                    accept=".json"
                    onChange={handleImportLayout}
                    style={{ display: 'none' }}
                  />
                </label>
                <span className="mx-1 text-muted">|</span>
              </>
            )}

            <button
              onClick={() => setIsPreview(!isPreview)}
              className={`btn btn-sm d-flex align-items-center ${isPreview ? 'btn-warning' : 'btn-outline-warning'}`}
              title={isPreview ? 'Editor Mode' : 'Preview Mode'}
            >
              <Play size={16} />
            </button>

            {!isPreview && (
              <button
                onClick={() => handleSave(false)}
                disabled={isSaving}
                className="btn btn-success btn-sm d-flex align-items-center"
                title="Save Layout"
              >
                <Save size={16} />
              </button>
            )}
          </div>
        </div>
      </header>

      {/* Main Workspace Frame */}
      <div className="d-flex flex-grow-1 overflow-hidden" style={{ height: focusMode ? 'calc(100vh - 92px)' : 'calc(100vh - 140px)' }}>

        {/* Left Toolbar */}
        {!isPreview && (
          <Toolbar
            activeTool={activeTool}
            setActiveTool={setActiveTool}
            iconMapping={iconMapping}
            onOpenCustomizeModal={() => setIsCustomizingToolbar(true)}
          />
        )}

        {/* Zoomable Canvas Workspace */}
        <div className="flex-grow-1 h-100 bg-light position-relative overflow-hidden">
          {message && (
            <div
              className={`alert alert-${message.type === 'error' ? 'danger' : message.type === 'success' ? 'success' : 'info'} position-absolute m-3 px-3 py-2 shadow-sm`}
              style={{ zIndex: 1000000, top: 10, right: 20, fontSize: '13px' }}
            >
              <Info size={14} className="mr-1 d-inline" /> {message.text}
            </div>
          )}

          <CanvasWorkspace
            activeTool={activeTool}
            setActiveTool={setActiveTool}
            sections={sections}
            setSections={setSections}
            seats={seats}
            setSeats={setSeats}
            gates={gates}
            setGates={setGates}
            pricingCategories={pricingCategories}
            selectedIds={selectedIds}
            setSelectedIds={setSelectedIds}
            zoomScale={zoomScale}
            setZoomScale={setZoomScale}
            snapToGrid={snapToGrid}
            gridSize={gridSize}
            isPreview={isPreview}
            recordHistory={recordHistory}
            focusMode={focusMode}
            onUndo={handleUndo}
            onRedo={handleRedo}
            onSave={() => handleSave(false)}
          />
        </div>

        {/* Right Properties Panel */}
        <PropertiesPanel
          selectedIds={selectedIds}
          sections={sections}
          seats={seats}
          gates={gates}
          pricingCategories={pricingCategories}
          onPropertyChange={handlePropertyChange}
          onBulkPropertyChange={handleBulkPropertyChange}
          isPreview={isPreview}
          onBulkRenameSeats={handleBulkRenameSeats}
          onDuplicateSeat={handleDuplicateSeat}
        />
      </div>

      {/* Bottom Status Area */}
      <footer className="bg-light border-top py-2 px-3 d-flex align-items-center justify-content-between text-muted" style={{ fontSize: '12px' }}>
        <div className="d-flex align-items-center">
          <span>Capacity: <strong>{seats.filter(s => s.seat_type !== 'BLOCKED' && !s.is_removed && s.is_visible).length} Seats</strong> ({sections.length} Sections)</span>
          <span className="mx-2">•</span>
          <span>Selected: <strong>{selectedIds.length} Object(s)</strong></span>
        </div>
        <div className="d-flex align-items-center">
          <label className="mb-0 d-flex align-items-center text-nowrap mr-3" style={{ cursor: 'pointer' }}>
            <input
              type="checkbox"
              checked={snapToGrid}
              onChange={(e) => setSnapToGrid(e.target.checked)}
              className="mr-2"
              disabled={isPreview}
            /> Snap to Grid
          </label>
          {snapToGrid && (
            <select
              value={gridSize}
              onChange={(e) => setGridSize(parseInt(e.target.value))}
              className="form-control form-control-sm py-0 h-auto mr-3"
              style={{ fontSize: '11px', width: '65px' }}
              disabled={isPreview}
            >
              <option value={10}>10px</option>
              <option value={20}>20px</option>
              <option value={30}>30px</option>
              <option value={40}>40px</option>
            </select>
          )}
          <span className="text-nowrap ml-1">Zoom: <strong>{Math.round(zoomScale * 100)}%</strong></span>
        </div>
      </footer>

      {/* Pricing Categories Manager Dialog */}
      {showPricingManager && (
        <PricingManager
          categories={pricingCategories}
          onClose={() => {
            setShowPricingManager(false);
            fetchPricingCategories(); // Refresh local list
          }}
        />
      )}

      {/* Seating Auto-Generator Dialog */}
      {showGenerator && (
        <AutoGeneratorDialog
          sections={sections}
          pricingCategories={pricingCategories}
          onClose={() => setShowGenerator(false)}
          onGenerate={(generatedSeats, newSection) => {
            const nextSections = newSection ? [...sections, newSection] : sections;
            const nextSeats = [...seats, ...generatedSeats];

            setSections(nextSections);
            setSeats(nextSeats);
            recordHistory(nextSections, nextSeats, gates);
            setShowGenerator(false);
            showStatusMessage(`Successfully generated ${generatedSeats.length} seats!`, 'success');
          }}
        />
      )}

      {/* Customize Toolbox Modal */}
      {isCustomizingToolbar && (
        <CustomizeToolboxDialog
          onClose={() => setIsCustomizingToolbar(false)}
          iconMapping={iconMapping}
          onSave={(newMapping) => {
            setIconMapping(newMapping);
            localStorage.setItem('venue-designer-icon-mapping', JSON.stringify(newMapping));
            setIsCustomizingToolbar(false);
            showStatusMessage('Toolbox icons customized successfully!', 'success');
          }}
        />
      )}
    </div>
  );
};

export default App;
