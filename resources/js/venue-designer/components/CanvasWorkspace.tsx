import React, { useRef, useState, useEffect } from 'react';
import { Stage, Layer, Rect, Text, Line, Group, Transformer } from 'react-konva';
import { PricingCategory, Section, Seat, Gate } from '../types.ts';
import { ZoomIn, ZoomOut, Maximize } from 'lucide-react';
import * as LucideIcons from 'lucide-react';

interface CanvasWorkspaceProps {
  activeTool: string;
  setActiveTool: (tool: string) => void;
  sections: Section[];
  setSections: (sections: Section[]) => void;
  seats: Seat[];
  setSeats: (seats: Seat[]) => void;
  gates: Gate[];
  setGates: (gates: Gate[]) => void;
  pricingCategories: PricingCategory[];
  selectedIds: { id: string | number; type: 'seat' | 'section' | 'gate' }[];
  setSelectedIds: (ids: { id: string | number; type: 'seat' | 'section' | 'gate' }[]) => void;
  zoomScale: number;
  setZoomScale: (scale: number) => void;
  snapToGrid: boolean;
  gridSize: number;
  isPreview: boolean;
  recordHistory: (sections: Section[], seats: Seat[], gates: Gate[]) => void;
  focusMode: boolean;
  onUndo?: () => void;
  onRedo?: () => void;
  onSave?: () => void;
}

const CanvasWorkspace: React.FC<CanvasWorkspaceProps> = ({
  activeTool,
  setActiveTool,
  sections,
  setSections,
  seats,
  setSeats,
  gates,
  setGates,
  pricingCategories: _pricingCategories,
  selectedIds,
  setSelectedIds,
  zoomScale,
  setZoomScale,
  snapToGrid,
  gridSize,
  isPreview,
  recordHistory,
  focusMode,
  onUndo,
  onRedo,
  onSave
}) => {
  const stageRef = useRef<any>(null);
  const containerRef = useRef<HTMLDivElement>(null);
  
  // Box multi-selection coordinates
  const [selectBox, setSelectBox] = useState<{ x1: number; y1: number; x2: number; y2: number } | null>(null);
  const isSelecting = useRef<boolean>(false);
  const dragStartPositions = useRef<Record<string, { x: number; y: number }>>({});
  const isPanning = useRef<boolean>(false);
  const [activeGuides, setActiveGuides] = useState<{ x: number[]; y: number[] }>({ x: [], y: [] });
  const clipboardRef = useRef<{ seats: Seat[]; gates: Gate[] }>({ seats: [], gates: [] });

  // Auto-resize stage to fit container
  useEffect(() => {
    const handleResize = () => {
      const stage = stageRef.current;
      const container = containerRef.current;
      if (stage && container) {
        stage.width(container.clientWidth);
        stage.height(container.clientHeight);
      }
    };
    handleResize();
    const timeoutId = setTimeout(handleResize, 50); // Resize after DOM redraw completes
    window.addEventListener('resize', handleResize);
    return () => {
      clearTimeout(timeoutId);
      window.removeEventListener('resize', handleResize);
    };
  }, [focusMode]);

  // Handle global keyboard shortcuts: delete, undo, redo, copy, paste
  useEffect(() => {
    const handleKeyDown = (e: KeyboardEvent) => {
      if (
        document.activeElement?.tagName === 'INPUT' ||
        document.activeElement?.tagName === 'TEXTAREA' ||
        document.activeElement?.getAttribute('contenteditable') === 'true'
      ) {
        return;
      }

      const isModKey = e.metaKey || e.ctrlKey;
      const key = e.key.toLowerCase();

      // Save: Ctrl/Cmd + S
      if (isModKey && key === 's') {
        e.preventDefault();
        onSave?.();
        return;
      }

      // Undo: Ctrl/Cmd + Z (without Shift)
      if (isModKey && key === 'z' && !e.shiftKey) {
        e.preventDefault();
        onUndo?.();
        return;
      }

      // Redo: Ctrl/Cmd + Y or Ctrl/Cmd + Shift + Z
      if (isModKey && (key === 'y' || (key === 'z' && e.shiftKey))) {
        e.preventDefault();
        onRedo?.();
        return;
      }

      // Copy: Ctrl/Cmd + C
      if (isModKey && key === 'c') {
        e.preventDefault();
        const selectedSeats = seats.filter(s => selectedIds.some(item => item.id === s.id && item.type === 'seat'));
        const selectedGates = gates.filter(g => selectedIds.some(item => item.id === g.id && item.type === 'gate'));
        clipboardRef.current = { seats: selectedSeats, gates: selectedGates };
        return;
      }

      // Paste: Ctrl/Cmd + V
      if (isModKey && key === 'v') {
        e.preventDefault();
        const { seats: copiedSeats, gates: copiedGates } = clipboardRef.current;
        if (copiedSeats.length === 0 && copiedGates.length === 0) return;

        const newSeats: Seat[] = [];
        const newGates: Gate[] = [];
        const pastedIds: { id: string | number; type: 'seat' | 'section' | 'gate' }[] = [];
        const offset = 30; // Shift pasted items slightly for visibility

        copiedSeats.forEach((s, index) => {
          const newId = `seat_${Date.now()}_${index}`;
          newSeats.push({
            ...s,
            id: newId,
            x: s.x + offset,
            y: s.y + offset,
            is_locked: false,
            group_id: s.group_id ? `${s.group_id}_paste` : undefined
          });
          pastedIds.push({ id: newId, type: 'seat' });
        });

        copiedGates.forEach((g, index) => {
          const newId = `gate_${Date.now()}_${index}`;
          newGates.push({
            ...g,
            id: newId,
            x: g.x + offset,
            y: g.y + offset,
            is_locked: false,
            group_id: g.group_id ? `${g.group_id}_paste` : undefined
          });
          pastedIds.push({ id: newId, type: 'gate' });
        });

        const nextSeats = [...seats, ...newSeats];
        const nextGates = [...gates, ...newGates];

        setSeats(nextSeats);
        setGates(nextGates);
        setSelectedIds(pastedIds);
        recordHistory(sections, nextSeats, nextGates);
        return;
      }

      // Delete: Backspace or Delete
      if (e.key === 'Delete' || e.key === 'Backspace') {
        if (selectedIds.length === 0) return;

        let nextSections = [...sections];
        let nextSeats = [...seats];
        let nextGates = [...gates];

        selectedIds.forEach(item => {
          if (item.type === 'seat') {
            nextSeats = nextSeats.filter(s => `${s.id}` !== `${item.id}`);
          } else if (item.type === 'section') {
            nextSections = nextSections.filter(sec => `${sec.id}` !== `${item.id}` && `${sec.client_id}` !== `${item.id}`);
            nextSeats = nextSeats.map(s => `${s.section_id}` === `${item.id}` ? { ...s, section_id: null } : s);
          } else if (item.type === 'gate') {
            nextGates = nextGates.filter(g => `${g.id}` !== `${item.id}`);
          }
        });

        setSections(nextSections);
        setSeats(nextSeats);
        setGates(nextGates);
        setSelectedIds([]);
        recordHistory(nextSections, nextSeats, nextGates);
      }
    };

    window.addEventListener('keydown', handleKeyDown);
    return () => window.removeEventListener('keydown', handleKeyDown);
  }, [
    selectedIds,
    sections,
    seats,
    gates,
    setSections,
    setSeats,
    setGates,
    setSelectedIds,
    recordHistory,
    onUndo,
    onRedo,
    onSave
  ]);

  const snap = (val: number) => {
    if (!snapToGrid) return val;
    return Math.round(val / gridSize) * gridSize;
  };

  const transformerRef = useRef<any>(null);

  // Attach transformer to selected non-seat elements
  useEffect(() => {
    if (isPreview) {
      if (transformerRef.current) {
        transformerRef.current.nodes([]);
      }
      return;
    }

    const stage = stageRef.current;
    const transformer = transformerRef.current;
    if (stage && transformer) {
      const nonSeatSelected = selectedIds.filter(item => item.type !== 'seat');
      if (nonSeatSelected.length > 0) {
        const nodes = nonSeatSelected
          .map(item => {
            const name = `gate-${item.id}`;
            let node = stage.findOne(`.${name}`);
            if (!node) {
              const secName = `section-${item.id}`;
              node = stage.findOne(`.${secName}`);
            }
            return node;
          })
          .filter(Boolean);
        transformer.nodes(nodes);
      } else {
        transformer.nodes([]);
      }
      transformer.getLayer()?.batchDraw();
    }
  }, [selectedIds, isPreview, sections, gates]);

  const handleTransformEnd = (e: any, id: string | number, type: 'section' | 'gate') => {
    const node = e.target;
    const newX = snap(node.x());
    const newY = snap(node.y());
    
    let originalW = 100;
    let originalH = 100;
    if (type === 'section') {
      const sec = sections.find(s => s.id === id || s.client_id === id);
      if (sec) {
        originalW = sec.w;
        originalH = sec.h;
      }
    } else if (type === 'gate') {
      const gate = gates.find(g => g.id === id);
      if (gate) {
        originalW = gate.w;
        originalH = gate.h;
      }
    }

    const newW = snap(Math.max(10, Math.round(originalW * node.scaleX())));
    const newH = snap(Math.max(10, Math.round(originalH * node.scaleY())));
    const newRotation = Math.round(node.rotation());

    node.scaleX(1);
    node.scaleY(1);

    let nextSections = [...sections];
    let nextSeats = [...seats];
    let nextGates = [...gates];

    if (type === 'section') {
      nextSections = sections.map(s => (s.id === id || s.client_id === id) ? { ...s, x: newX, y: newY, w: newW, h: newH, rotation: newRotation } : s);
      setSections(nextSections);
    } else if (type === 'gate') {
      nextGates = gates.map(g => g.id === id ? { ...g, x: newX, y: newY, w: newW, h: newH, rotation: newRotation } : g);
      setGates(nextGates);
    }

    recordHistory(nextSections, nextSeats, nextGates);
  };

  // Zooming stage via controls
  const handleZoom = (factor: number) => {
    const stage = stageRef.current;
    if (!stage) return;
    const nextScale = Math.max(0.15, Math.min(zoomScale * factor, 3.0));
    setZoomScale(nextScale);
    stage.scale({ x: nextScale, y: nextScale });
  };

  const handleFitScreen = () => {
    const stage = stageRef.current;
    if (!stage) return;
    stage.position({ x: 50, y: 50 });
    stage.scale({ x: 0.9, y: 0.9 });
    setZoomScale(0.9);
  };

  // Mouse wheel zoom
  const handleWheel = (e: any) => {
    e.evt.preventDefault();
    const stage = stageRef.current;
    if (!stage) return;
    const oldScale = stage.scaleX();
    const pointer = stage.getPointerPosition();
    if (!pointer) return;

    const mousePointTo = {
      x: (pointer.x - stage.x()) / oldScale,
      y: (pointer.y - stage.y()) / oldScale,
    };

    const zoomSpeed = 1.08;
    const newScale = e.evt.deltaY < 0 ? oldScale * zoomSpeed : oldScale / zoomSpeed;
    const boundedScale = Math.max(0.15, Math.min(newScale, 3.0));

    setZoomScale(boundedScale);
    stage.scale({ x: boundedScale, y: boundedScale });

    const newPos = {
      x: pointer.x - mousePointTo.x * boundedScale,
      y: pointer.y - mousePointTo.y * boundedScale,
    };
    stage.position(newPos);
  };

  // Mouse down: Start drag-panning or multi-select box
  const handleMouseDown = (e: any) => {
    // If clicking on background grid, handle drag / select-box
    const stage = stageRef.current;
    if (!stage) return;

    if (e.target === stage || e.target.name() === 'grid-background') {
      const pos = stage.getPointerPosition();
      if (!pos) return;
      const worldX = (pos.x - stage.x()) / stage.scaleX();
      const worldY = (pos.y - stage.y()) / stage.scaleY();

      if (activeTool === 'select' && !e.evt.spaceKey) {
        // Multi-select dragging box
        isSelecting.current = true;
        setSelectBox({ x1: worldX, y1: worldY, x2: worldX, y2: worldY });
      } else {
        // Panning Stage
        isPanning.current = true;
        stage.startDrag();
      }
    }
  };

  // Mouse move: update select-box size
  const handleMouseMove = () => {
    if (!isSelecting.current || !selectBox) return;
    const stage = stageRef.current;
    if (!stage) return;
    const pos = stage.getPointerPosition();
    if (!pos) return;
    const worldX = (pos.x - stage.x()) / stage.scaleX();
    const worldY = (pos.y - stage.y()) / stage.scaleY();

    setSelectBox({
      ...selectBox,
      x2: worldX,
      y2: worldY
    });
  };

  // Mouse up: resolve box selection or placement
  const handleMouseUp = (_e: any) => {
    const stage = stageRef.current;
    if (!stage) return;

    if (isSelecting.current && selectBox) {
      isSelecting.current = false;
      
      const xMin = Math.min(selectBox.x1, selectBox.x2);
      const xMax = Math.max(selectBox.x1, selectBox.x2);
      const yMin = Math.min(selectBox.y1, selectBox.y2);
      const yMax = Math.max(selectBox.y1, selectBox.y2);

      // Find seats/gates/sections intersecting the selection box
      const matches: typeof selectedIds = [];
      seats.filter(s => !s.is_removed).forEach(s => {
        const x1 = s.x;
        const y1 = s.y;
        const x2 = s.x + s.w;
        const y2 = s.y + s.h;
        if (xMin <= x2 && xMax >= x1 && yMin <= y2 && yMax >= y1) {
          matches.push({ id: s.id!, type: 'seat' });
        }
      });
      gates.forEach(g => {
        const x1 = g.x;
        const y1 = g.y;
        const x2 = g.x + g.w;
        const y2 = g.y + g.h;
        if (xMin <= x2 && xMax >= x1 && yMin <= y2 && yMax >= y1) {
          matches.push({ id: g.id, type: 'gate' });
        }
      });
      sections.forEach(sec => {
        const x1 = sec.x;
        const y1 = sec.y;
        const x2 = sec.x + sec.w;
        const y2 = sec.y + sec.h;
        if (xMin <= x2 && xMax >= x1 && yMin <= y2 && yMax >= y1) {
          matches.push({ id: sec.id || sec.client_id!, type: 'section' });
        }
      });

      setSelectedIds(matches);
      setSelectBox(null);
      return;
    }

    if (isPanning.current) {
      isPanning.current = false;
      stage.stopDrag();
    }
  };

  // Spawn new element on clicking stage background
  const handleStageClick = (e: any) => {
    const stage = stageRef.current;
    if (!stage) return;

    if (e.target === stage || e.target.name() === 'grid-background') {
      // Deselect existing
      setSelectedIds([]);

      if (isPreview) return;

      const pos = stage.getPointerPosition();
      if (!pos) return;
      
      const x = (pos.x - stage.x()) / stage.scaleX();
      const y = (pos.y - stage.y()) / stage.scaleY();

      // Spawn Seat
      if (activeTool.startsWith('seat_')) {
        const typeMap: Record<string, Seat['seat_type']> = {
          'seat_regular': 'REGULAR',
          'seat_vip': 'VIP',
          'seat_premium': 'PREMIUM',
          'seat_accessible': 'ACCESSIBLE',
          'seat_companion': 'COMPANION',
          'seat_blocked': 'BLOCKED'
        };
        const seatType = typeMap[activeTool] || 'REGULAR';
        const newSeat: Seat = {
          id: 'seat_' + Date.now(),
          name: `Seat ${seats.length + 1}`,
          label: `${seats.length + 1}`,
          seatno: `${seats.length + 1}`,
          seat_type: seatType,
          x: snap(x - 16),
          y: snap(y - 16),
          w: 32,
          h: 32,
          rotation: 0,
          is_visible: true,
          is_removed: false,
          is_damaged: false,
          is_reserved: false
        };
        const nextSeats = [...seats, newSeat];
        setSeats(nextSeats);
        recordHistory(sections, nextSeats, gates);
        setActiveTool('select');
      } 
      // Spawn Gate / Venue Object
      else if (activeTool !== 'select' && activeTool !== 'eraser' && activeTool !== 'section') {
        const type = activeTool as Gate['type'];
        const labelMap: Record<string, string> = {
          'stage': 'STAGE',
          'entrance': 'ENTRANCE',
          'exit': 'EXIT',
          'restroom': 'RESTROOMS',
          'bar': 'BAR/CAFÉ',
          'stairs': 'STAIRS',
          'label': 'Custom Text',
          'shape': 'Custom Box'
        };
        const colorMap: Record<string, string> = {
          'stage': '#1e293b',
          'entrance': '#10b981',
          'exit': '#ef4444',
          'restroom': '#3b82f6',
          'bar': '#f59e0b',
          'stairs': '#64748b',
          'label': '#0f172a',
          'shape': '#e2e8f0'
        };
        const newGate: Gate = {
          id: 'gate_' + Date.now(),
          type,
          label: labelMap[type] || 'Venue Object',
          color: colorMap[type] || '#64748b',
          x: snap(x - 30),
          y: snap(y - 30),
          w: type === 'stage' ? 240 : type === 'label' ? 120 : 60,
          h: type === 'stage' ? 80 : type === 'label' ? 30 : 60,
          rotation: 0
        };
        const nextGates = [...gates, newGate];
        setGates(nextGates);
        recordHistory(sections, seats, nextGates);
        setActiveTool('select');
      }
    }
  };

  // Node Clicking (select or delete)
  const handleElementClick = (e: any, id: string | number, type: 'seat' | 'section' | 'gate') => {
    e.cancelBubble = true;
    
    if (isPreview) return;

    if (activeTool === 'eraser') {
      let nextSections = [...sections];
      let nextSeats = [...seats];
      let nextGates = [...gates];

      if (type === 'seat') {
        nextSeats = seats.filter(s => `${s.id}` !== `${id}`);
      } else if (type === 'section') {
        nextSections = sections.filter(sec => `${sec.id}` !== `${id}` && `${sec.client_id}` !== `${id}`);
        nextSeats = seats.map(s => `${s.section_id}` === `${id}` ? { ...s, section_id: null } : s);
      } else if (type === 'gate') {
        nextGates = gates.filter(g => `${g.id}` !== `${id}`);
      }

      setSections(nextSections);
      setSeats(nextSeats);
      setGates(nextGates);
      setSelectedIds([]);
      recordHistory(nextSections, nextSeats, nextGates);
      return;
    }

    if (e.evt.shiftKey) {
      const alreadySelected = selectedIds.some(item => item.id === id);
      let nextSelection = [...selectedIds];
      if (alreadySelected) {
        nextSelection = selectedIds.filter(item => item.id !== id);
      } else {
        nextSelection = [...selectedIds, { id, type }];
      }

      // Expand selection to include group mates if any item is grouped
      const expandedSelection = [...nextSelection];
      nextSelection.forEach(item => {
        let groupId: string | undefined;
        if (item.type === 'seat') {
          const seat = seats.find(s => s.id === item.id);
          groupId = seat?.group_id;
        } else if (item.type === 'gate') {
          const gate = gates.find(g => g.id === item.id);
          groupId = gate?.group_id;
        }

        if (groupId) {
          seats.forEach(s => {
            if (s.group_id === groupId && !expandedSelection.some(x => x.id === s.id && x.type === 'seat')) {
              expandedSelection.push({ id: s.id!, type: 'seat' });
            }
          });
          gates.forEach(g => {
            if (g.group_id === groupId && !expandedSelection.some(x => x.id === g.id && x.type === 'gate')) {
              expandedSelection.push({ id: g.id!, type: 'gate' });
            }
          });
        }
      });
      setSelectedIds(expandedSelection);
    } else {
      // Single Click: select the item and all its group mates (if any)
      const seat = type === 'seat' ? seats.find(s => s.id === id) : null;
      const gate = type === 'gate' ? gates.find(g => g.id === id) : null;
      const groupId = seat?.group_id || gate?.group_id;

      if (groupId) {
        const groupMembers: { id: string | number; type: 'seat' | 'section' | 'gate' }[] = [];
        seats.forEach(s => {
          if (s.group_id === groupId) groupMembers.push({ id: s.id!, type: 'seat' });
        });
        gates.forEach(g => {
          if (g.group_id === groupId) groupMembers.push({ id: g.id!, type: 'gate' });
        });
        setSelectedIds(groupMembers);
      } else {
        setSelectedIds([{ id, type }]);
      }
    }
  };

  // Dragging nodes handler
  const handleDragStart = (_e: any, id: string | number, type: 'seat' | 'section' | 'gate') => {
    const isSelected = selectedIds.some(item => item.id === id);
    let activeSelection = selectedIds;
    
    if (!isSelected) {
      const seat = type === 'seat' ? seats.find(s => s.id === id) : null;
      const gate = type === 'gate' ? gates.find(g => g.id === id) : null;
      const groupId = seat?.group_id || gate?.group_id;

      if (groupId) {
        const groupMembers: { id: string | number; type: 'seat' | 'section' | 'gate' }[] = [];
        seats.forEach(s => {
          if (s.group_id === groupId) groupMembers.push({ id: s.id!, type: 'seat' });
        });
        gates.forEach(g => {
          if (g.group_id === groupId) groupMembers.push({ id: g.id!, type: 'gate' });
        });
        activeSelection = groupMembers;
      } else {
        activeSelection = [{ id, type }];
      }
      setSelectedIds(activeSelection);
    } else {
      // Ensure all group mates of currently selected items are also included in activeSelection
      const expandedSelection = [...activeSelection];
      activeSelection.forEach(item => {
        let groupId: string | undefined;
        if (item.type === 'seat') {
          const seat = seats.find(s => s.id === item.id);
          groupId = seat?.group_id;
        } else if (item.type === 'gate') {
          const gate = gates.find(g => g.id === item.id);
          groupId = gate?.group_id;
        }

        if (groupId) {
          seats.forEach(s => {
            if (s.group_id === groupId && !expandedSelection.some(x => x.id === s.id && x.type === 'seat')) {
              expandedSelection.push({ id: s.id!, type: 'seat' });
            }
          });
          gates.forEach(g => {
            if (g.group_id === groupId && !expandedSelection.some(x => x.id === g.id && x.type === 'gate')) {
              expandedSelection.push({ id: g.id!, type: 'gate' });
            }
          });
        }
      });
      activeSelection = expandedSelection;
      setSelectedIds(activeSelection);
    }

    const positions: Record<string, { x: number; y: number }> = {};
    activeSelection.forEach(item => {
      if (item.type === 'seat') {
        const seat = seats.find(s => s.id === item.id);
        if (seat) positions[`seat-${item.id}`] = { x: seat.x, y: seat.y };
      } else if (item.type === 'section') {
        const sec = sections.find(s => s.id === item.id || s.client_id === item.id);
        if (sec) {
          const key = sec.id || sec.client_id!;
          positions[`section-${key}`] = { x: sec.x, y: sec.y };
        }
      } else if (item.type === 'gate') {
        const gate = gates.find(g => g.id === item.id);
        if (gate) positions[`gate-${item.id}`] = { x: gate.x, y: gate.y };
      }
    });
    dragStartPositions.current = positions;
  };

  const handleDragMove = (e: any, id: string | number, type: 'seat' | 'section' | 'gate') => {
    const key = `${type}-${id}`;
    const startPos = dragStartPositions.current[key];
    if (!startPos) return;

    // Get dimensions of currently dragged node
    let dragW = 32;
    let dragH = 32;
    if (type === 'seat') {
      const seat = seats.find(s => s.id === id);
      if (seat) {
        dragW = seat.w;
        dragH = seat.h;
      }
    } else if (type === 'section') {
      const sec = sections.find(s => s.id === id || s.client_id === id);
      if (sec) {
        dragW = sec.w;
        dragH = sec.h;
      }
    } else if (type === 'gate') {
      const gate = gates.find(g => g.id === id);
      if (gate) {
        dragW = gate.w;
        dragH = gate.h;
      }
    }

    // Collect all coordinates of other elements
    const otherAlignments: { x: number[]; y: number[] } = { x: [], y: [] };
    const addCoords = (x: number, y: number, w: number, h: number) => {
      otherAlignments.x.push(x, x + w / 2, x + w);
      otherAlignments.y.push(y, y + h / 2, y + h);
    };

    seats.filter(s => s.id !== id && !s.is_removed).forEach(s => addCoords(s.x, s.y, s.w, s.h));
    sections.filter(s => s.id !== id && s.client_id !== id).forEach(s => addCoords(s.x, s.y, s.w, s.h));
    gates.filter(g => g.id !== id).forEach(g => addCoords(g.x, g.y, g.w, g.h));

    let dragX = e.target.x();
    let dragY = e.target.y();

    const threshold = 6; // pixels within which guides appear and snap
    let guideLinesX: number[] = [];
    let guideLinesY: number[] = [];
    let snapX: number | null = null;
    let snapY: number | null = null;

    // Check X alignments (vertical guide lines)
    const currentXProps = [
      { val: dragX, offset: 0 },
      { val: dragX + dragW / 2, offset: dragW / 2 },
      { val: dragX + dragW, offset: dragW }
    ];

    for (const prop of currentXProps) {
      const closestX = otherAlignments.x.find(ox => Math.abs(ox - prop.val) < threshold);
      if (closestX !== undefined) {
        snapX = closestX - prop.offset;
        guideLinesX.push(closestX);
        break;
      }
    }

    // Check Y alignments (horizontal guide lines)
    const currentYProps = [
      { val: dragY, offset: 0 },
      { val: dragY + dragH / 2, offset: dragH / 2 },
      { val: dragY + dragH, offset: dragH }
    ];

    for (const prop of currentYProps) {
      const closestY = otherAlignments.y.find(oy => Math.abs(oy - prop.val) < threshold);
      if (closestY !== undefined) {
        snapY = closestY - prop.offset;
        guideLinesY.push(closestY);
        break;
      }
    }

    // Snap the dragged node
    if (snapX !== null) {
      e.target.x(snapX);
      dragX = snapX;
    }
    if (snapY !== null) {
      e.target.y(snapY);
      dragY = snapY;
    }

    // Set guide lines state
    setActiveGuides({ x: guideLinesX, y: guideLinesY });

    const dx = dragX - startPos.x;
    const dy = dragY - startPos.y;

    const stage = e.target.getStage();
    if (!stage) return;

    Object.entries(dragStartPositions.current).forEach(([k, start]) => {
      if (k === key) return;
      const node = stage.findOne(`.${k}`);
      if (node) {
        node.position({
          x: start.x + dx,
          y: start.y + dy
        });
      }
    });
    stage.batchDraw();
  };

  const handleDragEnd = (e: any, id: string | number, type: 'seat' | 'section' | 'gate') => {
    const key = `${type}-${id}`;
    const startPos = dragStartPositions.current[key];
    if (!startPos) return;

    setActiveGuides({ x: [], y: [] });

    // Determine dimensions of dragged node
    let dragW = 32;
    let dragH = 32;
    if (type === 'seat') {
      const seat = seats.find(s => s.id === id);
      if (seat) {
        dragW = seat.w;
        dragH = seat.h;
      }
    } else if (type === 'section') {
      const sec = sections.find(s => s.id === id || s.client_id === id);
      if (sec) {
        dragW = sec.w;
        dragH = sec.h;
      }
    } else if (type === 'gate') {
      const gate = gates.find(g => g.id === id);
      if (gate) {
        dragW = gate.w;
        dragH = gate.h;
      }
    }

    // Collect all coordinates of other elements
    const otherAlignments: { x: number[]; y: number[] } = { x: [], y: [] };
    const addCoords = (x: number, y: number, w: number, h: number) => {
      otherAlignments.x.push(x, x + w / 2, x + w);
      otherAlignments.y.push(y, y + h / 2, y + h);
    };

    seats.filter(s => s.id !== id && !s.is_removed).forEach(s => addCoords(s.x, s.y, s.w, s.h));
    sections.filter(s => s.id !== id && s.client_id !== id).forEach(s => addCoords(s.x, s.y, s.w, s.h));
    gates.filter(g => g.id !== id).forEach(g => addCoords(g.x, g.y, g.w, g.h));

    const finalDragX = e.target.x();
    const finalDragY = e.target.y();

    const threshold = 6;
    let isAlignedX = false;
    let isAlignedY = false;

    const currentXProps = [finalDragX, finalDragX + dragW / 2, finalDragX + dragW];
    for (const val of currentXProps) {
      if (otherAlignments.x.some(ox => Math.abs(ox - val) < threshold)) {
        isAlignedX = true;
        break;
      }
    }

    const currentYProps = [finalDragY, finalDragY + dragH / 2, finalDragY + dragH];
    for (const val of currentYProps) {
      if (otherAlignments.y.some(oy => Math.abs(oy - val) < threshold)) {
        isAlignedY = true;
        break;
      }
    }

    const primaryFinalX = isAlignedX ? finalDragX : snap(finalDragX);
    const primaryFinalY = isAlignedY ? finalDragY : snap(finalDragY);

    const snappedDx = primaryFinalX - startPos.x;
    const snappedDy = primaryFinalY - startPos.y;

    let nextSections = [...sections];
    let nextSeats = [...seats];
    let nextGates = [...gates];

    Object.entries(dragStartPositions.current).forEach(([k, start]) => {
      const finalX = start.x + snappedDx;
      const finalY = start.y + snappedDy;

      const parts = k.split('-');
      const itemType = parts[0];
      const itemId = parts.slice(1).join('-');

      const stage = e.target.getStage();
      if (stage) {
        const node = stage.findOne(`.${k}`);
        if (node) {
          node.position({ x: finalX, y: finalY });
        }
      }

      if (itemType === 'seat') {
        nextSeats = nextSeats.map(s => s.id?.toString() === itemId ? { ...s, x: finalX, y: finalY } : s);
      } else if (itemType === 'section') {
        nextSections = nextSections.map(s => (s.id?.toString() === itemId || s.client_id === itemId) ? { ...s, x: finalX, y: finalY } : s);
      } else if (itemType === 'gate') {
        nextGates = nextGates.map(g => g.id === itemId ? { ...g, x: finalX, y: finalY } : g);
      }
    });

    setSections(nextSections);
    setSeats(nextSeats);
    setGates(nextGates);
    dragStartPositions.current = {};

    recordHistory(nextSections, nextSeats, nextGates);
  };

  const getSelectionBoundingBox = () => {
    if (selectedIds.length === 0) return null;

    let minX = Infinity;
    let minY = Infinity;
    let maxX = -Infinity;
    let maxY = -Infinity;

    selectedIds.forEach(item => {
      let x = 0, y = 0, w = 32, h = 32;
      if (item.type === 'seat') {
        const seat = seats.find(s => s.id === item.id);
        if (seat) {
          x = seat.x; y = seat.y; w = seat.w; h = seat.h;
        }
      } else if (item.type === 'section') {
        const sec = sections.find(s => s.id === item.id || s.client_id === item.id);
        if (sec) {
          x = sec.x; y = sec.y; w = sec.w; h = sec.h;
        }
      } else if (item.type === 'gate') {
        const gate = gates.find(g => g.id === item.id);
        if (gate) {
          x = gate.x; y = gate.y; w = gate.w; h = gate.h;
        }
      }

      minX = Math.min(minX, x);
      minY = Math.min(minY, y);
      maxX = Math.max(maxX, x + w);
      maxY = Math.max(maxY, y + h);
    });

    if (minX === Infinity) return null;

    return { minX, minY, maxX, maxY };
  };

  const handleToggleLock = () => {
    const selectedSeatIds = selectedIds.filter(item => item.type === 'seat').map(item => item.id);
    const selectedGateIds = selectedIds.filter(item => item.type === 'gate').map(item => item.id);
    const selectedSecIds = selectedIds.filter(item => item.type === 'section').map(item => item.id);

    const isAnyLocked = [
      ...seats.filter(s => selectedSeatIds.includes(s.id!)),
      ...gates.filter(g => selectedGateIds.includes(g.id)),
      ...sections.filter(sec => selectedSecIds.includes(sec.id!) || selectedSecIds.includes(sec.client_id!))
    ].some(obj => obj.is_locked);

    const nextSeats = seats.map(s => selectedSeatIds.includes(s.id!) ? { ...s, is_locked: !isAnyLocked } : s);
    const nextGates = gates.map(g => selectedGateIds.includes(g.id) ? { ...g, is_locked: !isAnyLocked } : g);
    const nextSections = sections.map(sec => (selectedSecIds.includes(sec.id!) || selectedSecIds.includes(sec.client_id!)) ? { ...sec, is_locked: !isAnyLocked } : sec);

    setSeats(nextSeats);
    setGates(nextGates);
    setSections(nextSections);
    recordHistory(nextSections, nextSeats, nextGates);
  };

  const handleGroup = () => {
    const groupId = `group_${Date.now()}`;
    const selectedSeatIds = selectedIds.filter(item => item.type === 'seat').map(item => item.id);
    const selectedGateIds = selectedIds.filter(item => item.type === 'gate').map(item => item.id);

    const nextSeats = seats.map(s => selectedSeatIds.includes(s.id!) ? { ...s, group_id: groupId } : s);
    const nextGates = gates.map(g => selectedGateIds.includes(g.id) ? { ...g, group_id: groupId } : g);

    setSeats(nextSeats);
    setGates(nextGates);
    recordHistory(sections, nextSeats, nextGates);
  };

  const handleUngroup = () => {
    const selectedSeatIds = selectedIds.filter(item => item.type === 'seat').map(item => item.id);
    const selectedGateIds = selectedIds.filter(item => item.type === 'gate').map(item => item.id);

    const groupIdsToUngroup = new Set<string>();
    seats.forEach(s => {
      if (selectedSeatIds.includes(s.id!) && s.group_id) {
        groupIdsToUngroup.add(s.group_id);
      }
    });
    gates.forEach(g => {
      if (selectedGateIds.includes(g.id) && g.group_id) {
        groupIdsToUngroup.add(g.group_id);
      }
    });

    const nextSeats = seats.map(s => s.group_id && groupIdsToUngroup.has(s.group_id) ? { ...s, group_id: undefined } : s);
    const nextGates = gates.map(g => g.group_id && groupIdsToUngroup.has(g.group_id) ? { ...g, group_id: undefined } : g);

    setSeats(nextSeats);
    setGates(nextGates);
    recordHistory(sections, nextSeats, nextGates);
  };

  const handleDuplicateSelected = () => {
    const newSeats: Seat[] = [];
    const newGates: Gate[] = [];
    const duplicatedIds: { id: string | number; type: 'seat' | 'section' | 'gate' }[] = [];
    const offset = 20;

    selectedIds.forEach((item, index) => {
      if (item.type === 'seat') {
        const s = seats.find(x => x.id === item.id);
        if (s) {
          const newId = `seat_${Date.now()}_${index}`;
          newSeats.push({
            ...s,
            id: newId,
            x: s.x + offset,
            y: s.y + offset,
            is_locked: false,
            group_id: s.group_id ? `${s.group_id}_dup` : undefined
          });
          duplicatedIds.push({ id: newId, type: 'seat' });
        }
      } else if (item.type === 'gate') {
        const g = gates.find(x => x.id === item.id);
        if (g) {
          const newId = `gate_${Date.now()}_${index}`;
          newGates.push({
            ...g,
            id: newId,
            x: g.x + offset,
            y: g.y + offset,
            is_locked: false,
            group_id: g.group_id ? `${g.group_id}_dup` : undefined
          });
          duplicatedIds.push({ id: newId, type: 'gate' });
        }
      }
    });

    if (newSeats.length === 0 && newGates.length === 0) return;

    const nextSeats = [...seats, ...newSeats];
    const nextGates = [...gates, ...newGates];

    setSeats(nextSeats);
    setGates(nextGates);
    setSelectedIds(duplicatedIds);
    recordHistory(sections, nextSeats, nextGates);
  };

  const handleDeleteSelected = () => {
    let nextSections = [...sections];
    let nextSeats = [...seats];
    let nextGates = [...gates];

    selectedIds.forEach(item => {
      if (item.type === 'seat') {
        nextSeats = nextSeats.filter(s => `${s.id}` !== `${item.id}`);
      } else if (item.type === 'section') {
        nextSections = nextSections.filter(sec => `${sec.id}` !== `${item.id}` && `${sec.client_id}` !== `${item.id}`);
        nextSeats = nextSeats.map(s => `${s.section_id}` === `${item.id}` ? { ...s, section_id: null } : s);
      } else if (item.type === 'gate') {
        nextGates = nextGates.filter(g => `${g.id}` !== `${item.id}`);
      }
    });

    setSections(nextSections);
    setSeats(nextSeats);
    setGates(nextGates);
    setSelectedIds([]);
    recordHistory(nextSections, nextSeats, nextGates);
  };

  const renderFloatingToolbar = () => {
    const box = getSelectionBoundingBox();
    const stage = stageRef.current;
    if (!box || !stage) return null;

    const scale = stage.scaleX();
    const stageX = stage.x();
    const stageY = stage.y();

    const left = stageX + box.minX * scale;
    const right = stageX + box.maxX * scale;
    const top = stageY + box.minY * scale;

    const width = right - left;
    const centerX = left + width / 2;

    const selectedSeatIds = selectedIds.filter(item => item.type === 'seat').map(item => item.id);
    const selectedGateIds = selectedIds.filter(item => item.type === 'gate').map(item => item.id);
    const selectedSecIds = selectedIds.filter(item => item.type === 'section').map(item => item.id);

    const selectedSeats = seats.filter(s => selectedSeatIds.includes(s.id!));
    const selectedGates = gates.filter(g => selectedGateIds.includes(g.id));
    const selectedSections = sections.filter(sec => selectedSecIds.includes(sec.id!) || selectedSecIds.includes(sec.client_id!));

    const allObjects = [...selectedSeats, ...selectedGates, ...selectedSections];
    if (allObjects.length === 0) return null;

    const isAnyLocked = allObjects.some(obj => obj.is_locked);
    const isAnyGrouped = [...selectedSeats, ...selectedGates].some(obj => obj.group_id);

    return (
      <div 
        className="position-absolute bg-white rounded shadow-lg border p-1 d-flex align-items-center gap-1 transition-all"
        style={{
          left: `${centerX}px`,
          top: `${top - 48}px`,
          transform: 'translateX(-50%)',
          zIndex: 100000,
          borderRadius: '8px'
        }}
      >
        <button 
          onClick={handleToggleLock}
          className={`btn btn-xs ${isAnyLocked ? 'btn-outline-warning' : 'btn-outline-secondary'} border-0 px-2 py-1`}
          title={isAnyLocked ? 'Unlock Selected' : 'Lock Selected'}
          style={{ padding: '4px 8px' }}
        >
          {isAnyLocked ? <LucideIcons.Unlock size={14} strokeWidth={1.5} /> : <LucideIcons.Lock size={14} strokeWidth={1.5} />}
        </button>

        {selectedIds.length > 1 && (
          <button 
            onClick={isAnyGrouped ? handleUngroup : handleGroup}
            className={`btn btn-xs ${isAnyGrouped ? 'btn-outline-primary' : 'btn-outline-secondary'} border-0 px-2 py-1`}
            title={isAnyGrouped ? 'Ungroup Selected' : 'Group Selected'}
            style={{ padding: '4px 8px' }}
          >
            {isAnyGrouped ? <LucideIcons.Layers size={14} strokeWidth={1.5} /> : <LucideIcons.Grid size={14} strokeWidth={1.5} />}
          </button>
        )}

        <button 
          onClick={handleDuplicateSelected}
          className="btn btn-xs btn-outline-secondary border-0 px-2 py-1"
          title="Duplicate Selected"
          style={{ padding: '4px 8px' }}
        >
          <LucideIcons.Copy size={14} strokeWidth={1.5} />
        </button>

        <button 
          onClick={handleDeleteSelected}
          className="btn btn-xs btn-outline-danger border-0 px-2 py-1"
          title="Delete Selected"
          style={{ padding: '4px 8px' }}
        >
          <LucideIcons.Trash2 size={14} strokeWidth={1.5} />
        </button>
      </div>
    );
  };

  // Render grid lines helper
  const renderGridLines = () => {
    const lines = [];
    const size = 3000;
    for (let i = 0; i <= size; i += gridSize * 2) {
      lines.push(<Line key={`v-${i}`} points={[i, 0, i, size]} stroke="#f1f5f9" strokeWidth={1} name="grid-line" />);
      lines.push(<Line key={`h-${i}`} points={[0, i, size, i]} stroke="#f1f5f9" strokeWidth={1} name="grid-line" />);
    }
    return lines;
  };

  const getSeatColor = (seat: Seat) => {
    if (!seat.is_visible) return 'rgba(203, 213, 225, 0.2)'; // semi-transparent
    if (seat.is_removed) return 'transparent';
    if (seat.is_damaged) return '#ef4444'; // Red

    // Default seat type colors
    const typeColors = {
      REGULAR: '#ccffe2', // Light Green
      VIP: '#fef3c7',     // Light Yellow
      PREMIUM: '#eff6ff', // Light Blue
      ACCESSIBLE: '#e0f2fe',
      COMPANION: '#f3f4f6',
      BLOCKED: '#fca5a5'
    };
    return typeColors[seat.seat_type] || '#ccffe2';
  };

  const getSeatBorder = (seat: Seat) => {
    if (seat.is_damaged) return '#dc2626';
    if (seat.is_reserved) return '#475569';

    const typeBorders = {
      REGULAR: '#01710c',
      VIP: '#d97706',
      PREMIUM: '#2563eb',
      ACCESSIBLE: '#0284c7',
      COMPANION: '#64748b',
      BLOCKED: '#b91c1c'
    };
    return typeBorders[seat.seat_type] || '#cbd5e1';
  };

  return (
    <div className="w-100 h-100 position-relative" ref={containerRef}>
      {/* Zoom / Workspace Controls */}
      <div className="position-absolute d-flex gap-2 m-3" style={{ right: 10, top: 10, zIndex: 1000 }}>
        <button onClick={() => handleZoom(1.15)} className="btn btn-sm btn-white border shadow-sm rounded-circle p-2" title="Zoom In"><ZoomIn size={16} /></button>
        <button onClick={() => handleZoom(0.85)} className="btn btn-sm btn-white border shadow-sm rounded-circle p-2" title="Zoom Out"><ZoomOut size={16} /></button>
        <button onClick={handleFitScreen} className="btn btn-sm btn-white border shadow-sm rounded-circle p-2" title="Reset View"><Maximize size={16} /></button>
      </div>

      {/* Konva stage canvas */}
      <Stage
        ref={stageRef}
        width={800}
        height={600}
        onWheel={handleWheel}
        onMouseDown={handleMouseDown}
        onMouseMove={handleMouseMove}
        onMouseUp={handleMouseUp}
        onClick={handleStageClick}
      >
        <Layer>
          {/* Background grid */}
          <Rect
            x={0}
            y={0}
            width={3000}
            height={3000}
            fill="#fafafa"
            name="grid-background"
          />
          {renderGridLines()}

          {/* Render Sections */}
          {sections.map(sec => {
            const isSelected = selectedIds.some(item => item.id === sec.id || item.id === sec.client_id);
            return (
              <Group
                key={sec.id || sec.client_id}
                name={`section-${sec.id || sec.client_id}`}
                x={sec.x}
                y={sec.y}
                rotation={sec.rotation}
                draggable={!isPreview && activeTool === 'select' && !sec.is_locked}
                onDragStart={(e) => handleDragStart(e, sec.id || sec.client_id!, 'section')}
                onDragMove={(e) => handleDragMove(e, sec.id || sec.client_id!, 'section')}
                onDragEnd={(e) => handleDragEnd(e, sec.id || sec.client_id!, 'section')}
                onClick={(e) => handleElementClick(e, sec.id || sec.client_id!, 'section')}
                onTransformEnd={(e) => handleTransformEnd(e, sec.id || sec.client_id!, 'section')}
              >
                <Rect
                  x={0}
                  y={0}
                  width={sec.w}
                  height={sec.h}
                  fill={`${sec.color}15`}
                  stroke={isSelected ? '#2563eb' : sec.color}
                  strokeWidth={isSelected ? 3 : 1.5}
                  dash={[6, 4]}
                  cornerRadius={8}
                />
                <Text
                  text={`${sec.name} (${sec.code})`}
                  x={10}
                  y={10}
                  fontSize={14}
                  fontStyle="bold"
                  fill="#475569"
                  listening={false}
                />
                {sec.is_locked && (
                  <Text
                    text="🔒 Locked"
                    x={sec.w - 75}
                    y={10}
                    fontSize={11}
                    fill="#ef4444"
                    fontStyle="bold"
                    listening={false}
                  />
                )}
              </Group>
            );
          })}

          {/* Render Seats */}
          {seats.filter(s => !s.is_removed).map(seat => {
            const isSelected = selectedIds.some(item => item.id === seat.id);
            const seatFill = getSeatColor(seat);
            const seatBorder = getSeatBorder(seat);

            return (
              <Group
                key={seat.id}
                name={`seat-${seat.id}`}
                x={seat.x}
                y={seat.y}
                rotation={seat.rotation}
                draggable={!isPreview && activeTool === 'select' && !seat.is_locked}
                onDragStart={(e) => handleDragStart(e, seat.id!, 'seat')}
                onDragMove={(e) => handleDragMove(e, seat.id!, 'seat')}
                onDragEnd={(e) => handleDragEnd(e, seat.id!, 'seat')}
                onClick={(e) => handleElementClick(e, seat.id!, 'seat')}
              >
                {isPreview ? (
                  // Detailed Seat Style in Preview Mode
                  <Group listening={false}>
                    {/* Backrest */}
                    <Rect
                      x={seat.w * 0.125}
                      y={seat.h * 0.06}
                      width={seat.w * 0.75}
                      height={seat.h * 0.19}
                      fill={seatFill}
                      stroke={seatBorder}
                      strokeWidth={1.2}
                      cornerRadius={Math.max(1, seat.w * 0.06)}
                    />
                    {/* Left Armrest */}
                    <Rect
                      x={seat.w * 0.03}
                      y={seat.h * 0.28}
                      width={Math.max(2, seat.w * 0.09)}
                      height={seat.h * 0.5}
                      fill={seatFill}
                      stroke={seatBorder}
                      strokeWidth={1.0}
                      cornerRadius={Math.max(1, seat.w * 0.03)}
                    />
                    {/* Right Armrest */}
                    <Rect
                      x={seat.w * 0.88}
                      y={seat.h * 0.28}
                      width={Math.max(2, seat.w * 0.09)}
                      height={seat.h * 0.5}
                      fill={seatFill}
                      stroke={seatBorder}
                      strokeWidth={1.0}
                      cornerRadius={Math.max(1, seat.w * 0.03)}
                    />
                    {/* Cushion */}
                    <Rect
                      x={seat.w * 0.125}
                      y={seat.h * 0.28}
                      width={seat.w * 0.75}
                      height={seat.h * 0.62}
                      fill={seatFill}
                      stroke={seatBorder}
                      strokeWidth={1.2}
                      cornerRadius={Math.max(2, seat.w * 0.12)}
                    />
                  </Group>
                ) : (
                  // Standard Rounded Square Box in Editor Mode
                  <Rect
                    x={0}
                    y={0}
                    width={seat.w}
                    height={seat.h}
                    fill={seatFill}
                    stroke={isSelected ? '#2563eb' : seatBorder}
                    strokeWidth={isSelected ? 3 : seat.is_reserved ? 2.5 : 1.5}
                    cornerRadius={6}
                  />
                )}
                {seat.is_visible && !seat.is_removed && (
                  <Text
                    text={seat.label || ''}
                    x={0}
                    y={isPreview ? seat.h * 0.25 : 0} // Shift label down slightly in preview mode to center on cushion
                    width={seat.w}
                    height={seat.h}
                    fontSize={Math.max(8, seat.w * 0.35)}
                    fontStyle="bold"
                    align="center"
                    verticalAlign="middle"
                    fill={seat.is_damaged ? '#ef4444' : '#1e293b'}
                    listening={false}
                  />
                )}
                {seat.is_locked && (
                  <Text
                    text="🔒"
                    x={seat.w - 12}
                    y={2}
                    fontSize={8}
                    listening={false}
                  />
                )}
              </Group>
            );
          })}

          {/* Render Gates / Markers */}
          {gates.map(gate => {
            const isSelected = selectedIds.some(item => item.id === gate.id);
            const isStage = gate.type === 'stage';
            const isLabel = gate.type === 'label';
            const borderRadius = gate.border_radius !== undefined ? gate.border_radius : (isStage ? 8 : 50);

            return (
              <Group
                key={gate.id}
                name={`gate-${gate.id}`}
                x={gate.x}
                y={gate.y}
                rotation={gate.rotation}
                draggable={!isPreview && activeTool === 'select' && !gate.is_locked}
                onDragStart={(e) => handleDragStart(e, gate.id, 'gate')}
                onDragMove={(e) => handleDragMove(e, gate.id, 'gate')}
                onDragEnd={(e) => handleDragEnd(e, gate.id, 'gate')}
                onClick={(e) => handleElementClick(e, gate.id, 'gate')}
                onTransformEnd={(e) => handleTransformEnd(e, gate.id, 'gate')}
              >
                <Rect
                  x={0}
                  y={0}
                  width={gate.w}
                  height={gate.h}
                  fill={isLabel ? 'rgba(0,0,0,0.001)' : gate.color}
                  stroke={isSelected ? '#2563eb' : isLabel ? 'transparent' : 'rgba(0,0,0,0.15)'}
                  strokeWidth={isSelected ? 3 : 1.5}
                  cornerRadius={borderRadius}
                />
                <Text
                  text={gate.label}
                  x={0}
                  y={0}
                  width={gate.w}
                  height={gate.h}
                  fontSize={isLabel ? (gate.font_size || 16) : 12}
                  fontFamily={isLabel ? (gate.font_family || 'Arial') : 'Arial'}
                  fontStyle={isLabel ? (gate.font_style || 'bold') : 'bold'}
                  textDecoration={isLabel ? (gate.text_decoration || 'none') : 'none'}
                  align="center"
                  verticalAlign="middle"
                  fill={isLabel ? gate.color : '#ffffff'}
                  listening={false}
                />
                {gate.is_locked && (
                  <Text
                    text="🔒"
                    x={gate.w - 12}
                    y={2}
                    fontSize={8}
                    listening={false}
                  />
                )}
              </Group>
            );
          })}

          {/* Render Selection box overlay */}
          {selectBox && (
            <Rect
              x={Math.min(selectBox.x1, selectBox.x2)}
              y={Math.min(selectBox.y1, selectBox.y2)}
              width={Math.abs(selectBox.x2 - selectBox.x1)}
              height={Math.abs(selectBox.y2 - selectBox.y1)}
              fill="rgba(37, 99, 235, 0.15)"
              stroke="#2563eb"
              strokeWidth={1}
              dash={[4, 2]}
            />
          )}

          {/* Render alignment guidelines */}
          {activeGuides.x.map((xVal, index) => (
            <Line
              key={`guide-x-${index}`}
              points={[xVal, -1000, xVal, 4000]}
              stroke="#ef4444"
              strokeWidth={1.5}
              dash={[4, 4]}
            />
          ))}
          {activeGuides.y.map((yVal, index) => (
            <Line
              key={`guide-y-${index}`}
              points={[-1000, yVal, 4000, yVal]}
              stroke="#ef4444"
              strokeWidth={1.5}
              dash={[4, 4]}
            />
          ))}

          {/* Render resizing transformer */}
          {!isPreview && selectedIds.filter(item => item.type !== 'seat').length > 0 && (
            <Transformer
              ref={transformerRef}
              enabledAnchors={[
                'top-left', 'top-center', 'top-right', 
                'middle-right', 'bottom-right', 'bottom-center', 
                'bottom-left', 'middle-left'
              ]}
              boundBoxFunc={(oldBox, newBox) => {
                if (newBox.width < 10 || newBox.height < 10) {
                  return oldBox;
                }
                return newBox;
              }}
            />
          )}
        </Layer>
      </Stage>
      
      {/* Floating Action Toolbar */}
      {!isPreview && selectedIds.length > 0 && renderFloatingToolbar()}
    </div>
  );
};

export default CanvasWorkspace;
