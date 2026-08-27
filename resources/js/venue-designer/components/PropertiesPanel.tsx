import React from 'react';
import { PricingCategory, Section, Seat, Gate } from '../types.ts';
import { Settings } from 'lucide-react';

interface PropertiesPanelProps {
  selectedIds: { id: string | number; type: 'seat' | 'section' | 'gate' }[];
  sections: Section[];
  seats: Seat[];
  gates: Gate[];
  pricingCategories: PricingCategory[];
  onPropertyChange: (type: 'seat' | 'section' | 'gate', id: string | number, key: string, value: any) => void;
  onBulkPropertyChange: (key: string, value: any) => void;
  isPreview: boolean;
  onBulkRenameSeats?: (prefix: string, startNumber: number, direction: 'left-to-right' | 'right-to-left') => void;
  onDuplicateSeat?: (seatId: string | number, count: number, direction: 'horizontal' | 'vertical', spacing: number) => void;
}

const PropertiesPanel: React.FC<PropertiesPanelProps> = ({
  selectedIds,
  sections,
  seats,
  gates,
  pricingCategories,
  onPropertyChange,
  onBulkPropertyChange,
  isPreview,
  onBulkRenameSeats,
  onDuplicateSeat
}) => {
  if (selectedIds.length === 0) {
    return (
      <div className="bg-light border-left p-3 d-flex flex-column align-items-center justify-content-center text-muted" style={{ width: '280px', minWidth: '280px' }}>
        <Settings size={36} className="mb-2 text-muted" />
        <p className="small mb-0 text-center">No object selected.<br />Click canvas elements to edit properties.</p>
      </div>
    );
  }

  // Bulk Selection Properties
  if (selectedIds.length > 1) {
    const seatCount = selectedIds.filter(item => item.type === 'seat').length;
    const gateCount = selectedIds.filter(item => item.type === 'gate').length;
    const sectionCount = selectedIds.filter(item => item.type === 'section').length;

    return (
      <div className="bg-light border-left p-3 d-flex flex-column gap-3 overflow-auto" style={{ width: '280px', minWidth: '280px' }}>
        <h4 className="h6 text-primary mb-2 font-weight-bold uppercase border-bottom pb-2">
          Bulk Editing
        </h4>
        
        <div className="small text-muted mb-2">
          Selected: <br />
          {seatCount > 0 && <span>• {seatCount} Seat(s)<br /></span>}
          {gateCount > 0 && <span>• {gateCount} Object(s)<br /></span>}
          {sectionCount > 0 && <span>• {sectionCount} Section(s)<br /></span>}
        </div>

        {seatCount > 0 && (
          <div className="d-flex flex-column gap-2 border-top pt-2">
            <div className="form-group mb-2">
              <label className="small font-weight-bold">Set Seat Type</label>
              <select 
                onChange={(e) => onBulkPropertyChange('seat_type', e.target.value)} 
                className="form-control form-control-sm"
                defaultValue=""
                disabled={isPreview}
              >
                <option value="" disabled>-- Select Type --</option>
                <option value="REGULAR">Regular Seat</option>
                <option value="VIP">VIP Seat</option>
                <option value="PREMIUM">Premium Seat</option>
                <option value="ACCESSIBLE">Accessible Seat</option>
                <option value="COMPANION">Companion Seat</option>
                <option value="BLOCKED">Blocked Seat</option>
              </select>
            </div>

            <div className="form-group mb-2">
              <label className="small font-weight-bold">Assign Section</label>
              <select 
                onChange={(e) => onBulkPropertyChange('section_id', e.target.value ? parseInt(e.target.value) : null)} 
                className="form-control form-control-sm"
                defaultValue=""
                disabled={isPreview}
              >
                <option value="" disabled>-- Select Section --</option>
                <option value="">None</option>
                {sections.map(sec => (
                  <option key={sec.id || sec.client_id} value={sec.id || sec.client_id}>
                    {sec.name} ({sec.code})
                  </option>
                ))}
              </select>
            </div>

            <div className="form-group mb-0 mt-2">
              <label className="small font-weight-bold d-block mb-1">Set Seat Visibility</label>
              <button 
                onClick={() => onBulkPropertyChange('is_visible', true)} 
                className="btn btn-outline-success btn-xs mr-2 mb-1"
                disabled={isPreview}
              >
                Show Selected
              </button>
              <button 
                onClick={() => onBulkPropertyChange('is_removed', true)} 
                className="btn btn-outline-danger btn-xs mb-1"
                disabled={isPreview}
              >
                Remove Selected
              </button>
            </div>
            {seatCount > 1 && (
              <div className="card p-2 border shadow-sm rounded bg-white mt-3" style={{ fontSize: '12px' }}>
                <h5 className="small font-weight-bold text-dark border-bottom pb-1 mb-2">Bulk Rename Seats</h5>
                <div className="form-group mb-2">
                  <label className="text-muted mb-1" style={{ fontSize: '11px' }}>Prefix (e.g. A)</label>
                  <input 
                    type="text" 
                    id="bulkRenamePrefix"
                    className="form-control form-control-sm"
                    placeholder="e.g. A"
                    defaultValue=""
                  />
                </div>
                <div className="form-group mb-2">
                  <label className="text-muted mb-1" style={{ fontSize: '11px' }}>Start Number (e.g. 3)</label>
                  <input 
                    type="number" 
                    id="bulkRenameStart"
                    className="form-control form-control-sm"
                    placeholder="e.g. 3"
                    defaultValue="1"
                  />
                </div>
                <div className="form-group mb-2">
                  <label className="text-muted mb-1" style={{ fontSize: '11px' }}>Ordering Direction</label>
                  <select id="bulkRenameDir" className="form-control form-control-sm" defaultValue="left-to-right">
                    <option value="left-to-right">Left to Right (A3, A4, A5...)</option>
                    <option value="right-to-left">Right to Left (...A5, A4, A3)</option>
                  </select>
                </div>
                <button 
                  onClick={() => {
                    const prefixInput = document.getElementById('bulkRenamePrefix') as HTMLInputElement;
                    const startInput = document.getElementById('bulkRenameStart') as HTMLInputElement;
                    const dirSelect = document.getElementById('bulkRenameDir') as HTMLSelectElement;
                    const prefix = prefixInput?.value || '';
                    const start = parseInt(startInput?.value || '1') || 1;
                    const dir = (dirSelect?.value || 'left-to-right') as 'left-to-right' | 'right-to-left';
                    onBulkRenameSeats?.(prefix, start, dir);
                  }}
                  className="btn btn-primary btn-xs w-100 mt-1 font-weight-bold"
                  disabled={isPreview}
                >
                  Apply Rename
                </button>
              </div>
            )}
          </div>
        )}
      </div>
    );
  }

  // Single Selection Properties
  const { id, type } = selectedIds[0];

  if (type === 'seat') {
    const seat = seats.find(s => s.id === id);
    if (!seat) return null;

    return (
      <div className="bg-light border-left p-3 d-flex flex-column gap-3 overflow-auto" style={{ width: '280px', minWidth: '280px', fontSize: '13px' }}>
        <h4 className="h6 text-primary mb-2 font-weight-bold uppercase border-bottom pb-2">
          Seat Properties
        </h4>
        
        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Seat Number / Label</label>
          <input
            type="text"
            value={seat.label}
            onChange={(e) => onPropertyChange('seat', id, 'label', e.target.value)}
            className="form-control form-control-sm"
            disabled={isPreview}
          />
        </div>

        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Row Number</label>
          <input
            type="number"
            value={seat.row_no || ''}
            onChange={(e) => onPropertyChange('seat', id, 'row_no', parseInt(e.target.value) || '')}
            className="form-control form-control-sm"
            placeholder="e.g. 1"
            disabled={isPreview}
          />
        </div>

        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Seat Type</label>
          <select
            value={seat.seat_type}
            onChange={(e) => onPropertyChange('seat', id, 'seat_type', e.target.value)}
            className="form-control form-control-sm"
            disabled={isPreview}
          >
            <option value="REGULAR">Regular Seat</option>
            <option value="VIP">VIP Seat</option>
            <option value="PREMIUM">Premium Seat</option>
            <option value="ACCESSIBLE">Accessible Seat</option>
            <option value="COMPANION">Companion Seat</option>
            <option value="BLOCKED">Blocked / Unavailable</option>
          </select>
        </div>

        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Assign Section</label>
          <select
            value={seat.section_id || ''}
            onChange={(e) => onPropertyChange('seat', id, 'section_id', e.target.value ? parseInt(e.target.value) : null)}
            className="form-control form-control-sm"
            disabled={isPreview}
          >
            <option value="">None (Independent)</option>
            {sections.map(sec => (
              <option key={sec.id || sec.client_id} value={sec.id || sec.client_id}>
                {sec.name} ({sec.code})
              </option>
            ))}
          </select>
        </div>

        <div className="row mb-2">
          <div className="col-6 pr-1">
            <label className="small font-weight-bold mb-1">X Pos</label>
            <input
              type="number"
              value={Math.round(seat.x)}
              onChange={(e) => onPropertyChange('seat', id, 'x', parseInt(e.target.value) || 0)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
          <div className="col-6 pl-1">
            <label className="small font-weight-bold mb-1">Y Pos</label>
            <input
              type="number"
              value={Math.round(seat.y)}
              onChange={(e) => onPropertyChange('seat', id, 'y', parseInt(e.target.value) || 0)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
        </div>

        <div className="row mb-2">
          <div className="col-6 pr-1">
            <label className="small font-weight-bold mb-1">Width</label>
            <input
              type="number"
              value={seat.w}
              onChange={(e) => onPropertyChange('seat', id, 'w', parseInt(e.target.value) || 32)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
          <div className="col-6 pl-1">
            <label className="small font-weight-bold mb-1">Rotation</label>
            <input
              type="number"
              value={seat.rotation}
              onChange={(e) => onPropertyChange('seat', id, 'rotation', parseInt(e.target.value) || 0)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
        </div>

        <hr className="my-2" />

        <div className="form-group mb-0">
          <label className="small font-weight-bold mb-1">Status States</label>
          <div className="form-check mb-1">
            <label className="form-check-label">
              <input
                type="checkbox"
                checked={seat.is_visible}
                onChange={(e) => onPropertyChange('seat', id, 'is_visible', e.target.checked)}
                className="form-check-input"
                disabled={isPreview}
              /> Visible to Customers
            </label>
          </div>
          <div className="form-check mb-1">
            <label className="form-check-label text-danger">
              <input
                type="checkbox"
                checked={seat.is_removed}
                onChange={(e) => onPropertyChange('seat', id, 'is_removed', e.target.checked)}
                className="form-check-input"
                disabled={isPreview}
              /> Removed / Hidden
            </label>
          </div>
          <div className="form-check mb-1">
            <label className="form-check-label text-warning">
              <input
                type="checkbox"
                checked={seat.is_damaged}
                onChange={(e) => onPropertyChange('seat', id, 'is_damaged', e.target.checked)}
                className="form-check-input"
                disabled={isPreview}
              /> Damaged
            </label>
          </div>
          <div className="form-check">
            <label className="form-check-label text-primary">
              <input
                type="checkbox"
                checked={seat.is_reserved}
                onChange={(e) => onPropertyChange('seat', id, 'is_reserved', e.target.checked)}
                className="form-check-input"
                disabled={isPreview}
              /> Reserved (Staff Only)
            </label>
          </div>
        </div>

        <hr className="my-2" />

        <div className="card p-2 border shadow-sm rounded bg-white" style={{ fontSize: '12px' }}>
          <h5 className="small font-weight-bold text-dark border-bottom pb-1 mb-2">Create Row / Clone Seat</h5>
          <div className="form-group mb-2">
            <label className="text-muted mb-0" style={{ fontSize: '11px' }}>Number of seats</label>
            <select id="dupCount" className="form-control form-control-sm" defaultValue="10">
              <option value="5">5 Seats</option>
              <option value="10">10 Seats</option>
              <option value="15">15 Seats</option>
              <option value="20">20 Seats</option>
              <option value="25">25 Seats</option>
              <option value="30">30 Seats</option>
            </select>
          </div>
          <div className="form-group mb-2">
            <label className="text-muted mb-0" style={{ fontSize: '11px' }}>Direction</label>
            <select id="dupDir" className="form-control form-control-sm" defaultValue="horizontal">
              <option value="horizontal">Horizontal (Right)</option>
              <option value="vertical">Vertical (Down)</option>
            </select>
          </div>
          <div className="form-group mb-2">
            <label className="text-muted mb-0" style={{ fontSize: '11px' }}>Spacing</label>
            <select id="dupSpacing" className="form-control form-control-sm" defaultValue="8">
              <option value="4">4px (Tight)</option>
              <option value="8">8px (Standard)</option>
              <option value="12">12px (Wide)</option>
              <option value="16">16px (Extra Wide)</option>
            </select>
          </div>
          <button 
            onClick={() => {
              const count = parseInt((document.getElementById('dupCount') as HTMLSelectElement)?.value || '10') || 10;
              const dir = ((document.getElementById('dupDir') as HTMLSelectElement)?.value || 'horizontal') as 'horizontal' | 'vertical';
              const spacing = parseInt((document.getElementById('dupSpacing') as HTMLSelectElement)?.value || '8') || 8;
              onDuplicateSeat?.(id, count, dir, spacing);
            }}
            className="btn btn-info text-white btn-xs w-100 mt-1 font-weight-bold"
            disabled={isPreview}
          >
            Spawn Row
          </button>
        </div>
      </div>
    );
  }

  if (type === 'section') {
    const sec = sections.find(s => s.id === id || s.client_id === id);
    if (!sec) return null;

    const targetId = sec.id || sec.client_id!;

    return (
      <div className="bg-light border-left p-3 d-flex flex-column gap-3 overflow-auto" style={{ width: '280px', minWidth: '280px', fontSize: '13px' }}>
        <h4 className="h6 text-primary mb-2 font-weight-bold uppercase border-bottom pb-2">
          Section Properties
        </h4>
        
        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Section Name</label>
          <input
            type="text"
            value={sec.name}
            onChange={(e) => onPropertyChange('section', targetId, 'name', e.target.value)}
            className="form-control form-control-sm"
            disabled={isPreview}
          />
        </div>

        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Section Code</label>
          <input
            type="text"
            value={sec.code}
            onChange={(e) => onPropertyChange('section', targetId, 'code', e.target.value)}
            className="form-control form-control-sm"
            disabled={isPreview}
          />
        </div>

        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Pricing Category</label>
          <select
            value={sec.pricing_category_id || ''}
            onChange={(e) => onPropertyChange('section', targetId, 'pricing_category_id', e.target.value ? parseInt(e.target.value) : null)}
            className="form-control form-control-sm"
            disabled={isPreview}
          >
            <option value="">None (Custom pricing)</option>
            {pricingCategories.map(cat => (
              <option key={cat.id} value={cat.id}>
                {cat.name} (₹ {cat.price})
              </option>
            ))}
          </select>
        </div>

        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Boundary color</label>
          <input
            type="color"
            value={sec.color}
            onChange={(e) => onPropertyChange('section', targetId, 'color', e.target.value)}
            className="form-control form-control-sm py-0"
            style={{ height: '30px' }}
            disabled={isPreview}
          />
        </div>

        <div className="row mb-2">
          <div className="col-6 pr-1">
            <label className="small font-weight-bold mb-1">X Pos</label>
            <input
              type="number"
              value={Math.round(sec.x)}
              onChange={(e) => onPropertyChange('section', targetId, 'x', parseInt(e.target.value) || 0)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
          <div className="col-6 pl-1">
            <label className="small font-weight-bold mb-1">Y Pos</label>
            <input
              type="number"
              value={Math.round(sec.y)}
              onChange={(e) => onPropertyChange('section', targetId, 'y', parseInt(e.target.value) || 0)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
        </div>

        <div className="row mb-2">
          <div className="col-6 pr-1">
            <label className="small font-weight-bold mb-1">Width</label>
            <input
              type="number"
              value={sec.w}
              onChange={(e) => onPropertyChange('section', targetId, 'w', parseInt(e.target.value) || 100)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
          <div className="col-6 pl-1">
            <label className="small font-weight-bold mb-1">Height</label>
            <input
              type="number"
              value={sec.h}
              onChange={(e) => onPropertyChange('section', targetId, 'h', parseInt(e.target.value) || 100)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
        </div>
      </div>
    );
  }

  if (type === 'gate') {
    const gate = gates.find(g => g.id === id);
    if (!gate) return null;

    return (
      <div className="bg-light border-left p-3 d-flex flex-column gap-3 overflow-auto" style={{ width: '280px', minWidth: '280px', fontSize: '13px' }}>
        <h4 className="h6 text-primary mb-2 font-weight-bold uppercase border-bottom pb-2">
          Object Properties
        </h4>
        
        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Object Label</label>
          <input
            type="text"
            value={gate.label}
            onChange={(e) => onPropertyChange('gate', id, 'label', e.target.value)}
            className="form-control form-control-sm"
            disabled={isPreview}
          />
        </div>

        {gate.type !== 'label' ? (
          <div className="form-group mb-2">
            <label className="small font-weight-bold mb-1">Color theme</label>
            <input
              type="color"
              value={gate.color}
              onChange={(e) => onPropertyChange('gate', id, 'color', e.target.value)}
              className="form-control form-control-sm py-0"
              style={{ height: '30px' }}
              disabled={isPreview}
            />
          </div>
        ) : (
          <>
            <div className="form-group mb-2">
              <label className="small font-weight-bold mb-1">Text Color</label>
              <input
                type="color"
                value={gate.color}
                onChange={(e) => onPropertyChange('gate', id, 'color', e.target.value)}
                className="form-control form-control-sm py-0"
                style={{ height: '30px' }}
                disabled={isPreview}
              />
            </div>
            
            <div className="form-group mb-2">
              <label className="small font-weight-bold mb-1">Font Family</label>
              <select
                value={gate.font_family || 'Arial'}
                onChange={(e) => onPropertyChange('gate', id, 'font_family', e.target.value)}
                className="form-control form-control-sm"
                disabled={isPreview}
              >
                <option value="Arial">Arial</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Courier New">Courier New</option>
                <option value="Georgia">Georgia</option>
                <option value="system-ui">System UI</option>
              </select>
            </div>

            <div className="form-group mb-2">
              <label className="small font-weight-bold mb-1">Font Size (px)</label>
              <input
                type="number"
                value={gate.font_size || 16}
                onChange={(e) => onPropertyChange('gate', id, 'font_size', parseInt(e.target.value) || 16)}
                className="form-control form-control-sm"
                disabled={isPreview}
              />
            </div>

            <div className="form-group mb-2">
              <label className="small font-weight-bold mb-1">Font Style</label>
              <select
                value={gate.font_style || 'bold'}
                onChange={(e) => onPropertyChange('gate', id, 'font_style', e.target.value)}
                className="form-control form-control-sm"
                disabled={isPreview}
              >
                <option value="normal">Normal</option>
                <option value="bold">Bold</option>
                <option value="italic">Italic</option>
                <option value="italic bold">Italic Bold</option>
              </select>
            </div>

            <div className="form-group mb-2">
              <label className="small font-weight-bold mb-1">Text Decoration</label>
              <select
                value={gate.text_decoration || 'none'}
                onChange={(e) => onPropertyChange('gate', id, 'text_decoration', e.target.value)}
                className="form-control form-control-sm"
                disabled={isPreview}
              >
                <option value="none">None</option>
                <option value="underline">Underline</option>
                <option value="line-through">Strikethrough</option>
                <option value="underline line-through">Underline & Strike</option>
              </select>
            </div>
          </>
        )}

        <div className="row mb-2">
          <div className="col-6 pr-1">
            <label className="small font-weight-bold mb-1">X Pos</label>
            <input
              type="number"
              value={Math.round(gate.x)}
              onChange={(e) => onPropertyChange('gate', id, 'x', parseInt(e.target.value) || 0)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
          <div className="col-6 pl-1">
            <label className="small font-weight-bold mb-1">Y Pos</label>
            <input
              type="number"
              value={Math.round(gate.y)}
              onChange={(e) => onPropertyChange('gate', id, 'y', parseInt(e.target.value) || 0)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
        </div>

        <div className="row mb-2">
          <div className="col-6 pr-1">
            <label className="small font-weight-bold mb-1">Width</label>
            <input
              type="number"
              value={gate.w}
              onChange={(e) => onPropertyChange('gate', id, 'w', parseInt(e.target.value) || 60)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
          <div className="col-6 pl-1">
            <label className="small font-weight-bold mb-1">Height</label>
            <input
              type="number"
              value={gate.h}
              onChange={(e) => onPropertyChange('gate', id, 'h', parseInt(e.target.value) || 60)}
              className="form-control form-control-sm"
              disabled={isPreview}
            />
          </div>
        </div>

        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Rotation (deg)</label>
          <input
            type="number"
            value={gate.rotation}
            onChange={(e) => onPropertyChange('gate', id, 'rotation', parseInt(e.target.value) || 0)}
            className="form-control form-control-sm"
            disabled={isPreview}
          />
        </div>

        <div className="form-group mb-2">
          <label className="small font-weight-bold mb-1">Border Radius (px)</label>
          <input
            type="number"
            value={gate.border_radius !== undefined ? gate.border_radius : (gate.type === 'stage' ? 8 : 50)}
            onChange={(e) => {
              const val = parseInt(e.target.value);
              onPropertyChange('gate', id, 'border_radius', isNaN(val) ? 0 : val);
            }}
            className="form-control form-control-sm"
            disabled={isPreview}
            min={0}
          />
        </div>
      </div>
    );
  }

  return null;
};

export default PropertiesPanel;
