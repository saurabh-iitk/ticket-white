import React, { useState } from 'react';
import { PricingCategory, Section, Seat } from '../types.ts';
import { LayoutGrid, X } from 'lucide-react';

interface AutoGeneratorDialogProps {
  sections: Section[];
  pricingCategories: PricingCategory[];
  onClose: () => void;
  onGenerate: (seats: Seat[], section: Section) => void;
}

const AutoGeneratorDialog: React.FC<AutoGeneratorDialogProps> = ({
  pricingCategories,
  onClose,
  onGenerate
}) => {
  const [secName, setSecName] = useState<string>('Main Balcony');
  const [secCode, setSecCode] = useState<string>('BALC');
  const [pricingCatId, setPricingCatId] = useState<number>(0);
  
  // Seating grid options
  const [rowCount, setRowCount] = useState<number>(5);
  const [startRowLetter, setStartRowLetter] = useState<string>('A');
  const [seatsPerRow, setSeatsPerRow] = useState<number>(12);
  const [startSeatNum, setStartSeatNum] = useState<number>(1);
  const [seatSpacing, setSeatSpacing] = useState<number>(40);
  const [rowSpacing, setRowSpacing] = useState<number>(46);
  const [reverseNumbering, setReverseNumbering] = useState<boolean>(false);
  
  // Curved Row Configuration
  const [layoutType, setLayoutType] = useState<'straight' | 'curved'>('straight');
  const [curveAngle, setCurveAngle] = useState<number>(60); // degrees arc
  const [curveRadius, setCurveRadius] = useState<number>(300); // pixels distance from focal point

  const handleGenerate = () => {
    if (!secName.trim() || !secCode.trim()) {
      alert('Section name and code are required.');
      return;
    }

    const tempSectionId = 'sec_' + Date.now();
    const generatedSeats: Seat[] = [];
    const startRowCharCode = startRowLetter.charCodeAt(0) || 65; // 'A'

    if (layoutType === 'straight') {
      // 1. Straight Section Layout Math
      for (let r = 0; r < rowCount; r++) {
        const rowLabel = String.fromCharCode(startRowCharCode + r);
        for (let s = 0; s < seatsPerRow; s++) {
          const seatNum = reverseNumbering ? (seatsPerRow - s) : (startSeatNum + s);
          // Coordinates relative to local offset
          const localX = s * seatSpacing + 30;
          const localY = r * rowSpacing + 50;

          generatedSeats.push({
            id: `seat_${tempSectionId}_${r}_${s}_${Date.now()}`,
            row_no: r + 1,
            col_no: s + 1,
            name: `${secCode}-${rowLabel}-${seatNum}`,
            label: `${seatNum}`,
            seatno: `${seatNum}`,
            section_id: tempSectionId,
            seat_type: 'REGULAR',
            x: localX + 100, // spawn offset
            y: localY + 100,
            w: 32,
            h: 32,
            rotation: 0,
            is_visible: true,
            is_removed: false,
            is_damaged: false,
            is_reserved: false
          });
        }
      }
    } else {
      // 2. Curved Section Layout Math (Radial Arc placement)
      const startAngle = -curveAngle / 2;
      const angleStep = seatsPerRow > 1 ? curveAngle / (seatsPerRow - 1) : 0;
      const focalCenterX = 350;
      const focalCenterY = 400; // Focal point lies below stage focus

      for (let r = 0; r < rowCount; r++) {
        const rowLabel = String.fromCharCode(startRowCharCode + r);
        // Each row radius scales outwards
        const currentRadius = curveRadius + (r * rowSpacing);

        for (let s = 0; s < seatsPerRow; s++) {
          const seatNum = reverseNumbering ? (seatsPerRow - s) : (startSeatNum + s);
          
          // Angle distributed along arc
          const angleDeg = startAngle + (s * angleStep) - 90; // Rotate facing UP stage
          const angleRad = (angleDeg * Math.PI) / 180;
          
          const localX = focalCenterX + currentRadius * Math.cos(angleRad);
          const localY = focalCenterY + currentRadius * Math.sin(angleRad);
          const rotation = angleDeg + 90; // orient angle facing inward

          generatedSeats.push({
            id: `seat_${tempSectionId}_${r}_${s}_${Date.now()}`,
            row_no: r + 1,
            col_no: s + 1,
            name: `${secCode}-${rowLabel}-${seatNum}`,
            label: `${seatNum}`,
            seatno: `${seatNum}`,
            section_id: tempSectionId,
            seat_type: 'REGULAR',
            x: localX + 50,
            y: localY + 50,
            w: 32,
            h: 32,
            rotation: Math.round(rotation),
            is_visible: true,
            is_removed: false,
            is_damaged: false,
            is_reserved: false
          });
        }
      }
    }

    // Determine bounding dimensions
    let minX = Infinity, maxX = -Infinity;
    let minY = Infinity, maxY = -Infinity;
    generatedSeats.forEach(s => {
      minX = Math.min(minX, s.x);
      maxX = Math.max(maxX, s.x + 32);
      minY = Math.min(minY, s.y);
      maxY = Math.max(maxY, s.y + 32);
    });

    const width = maxX - minX + 60;
    const height = maxY - minY + 80;

    // Shift seats to align cleanly inside section border coordinates
    generatedSeats.forEach(s => {
      s.x = s.x - minX + 130; // Centering offset
      s.y = s.y - minY + 140;
    });

    const newSection: Section = {
      client_id: tempSectionId,
      name: secName,
      code: secCode,
      pricing_category_id: pricingCatId > 0 ? pricingCatId : null,
      color: '#3b82f6',
      x: 100, // spawn location on workspace
      y: 100,
      w: width,
      h: height,
      rotation: 0
    };

    onGenerate(generatedSeats, newSection);
  };

  return (
    <div className="modal fade show d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)', zIndex: 1050 }} tabIndex={-1}>
      <div className="modal-dialog modal-lg modal-dialog-centered">
        <div className="modal-content shadow-lg border-0 rounded-lg">
          
          <div className="modal-header bg-dark text-white rounded-top px-4">
            <h5 className="modal-title font-weight-bold d-flex align-items-center">
              <LayoutGrid className="mr-2 text-primary" size={20} />
              Auto-Generate Seating Section
            </h5>
            <button type="button" onClick={onClose} className="close text-white" aria-label="Close">
              <X size={20} />
            </button>
          </div>

          <div className="modal-body p-4 row" style={{ maxHeight: '75vh', overflowY: 'auto' }}>
            
            {/* Column 1: Section Meta & Pricing */}
            <div className="col-md-6 border-right pr-4">
              <h6 className="font-weight-bold text-muted mb-3 uppercase">Section Details</h6>
              
              <div className="form-group mb-3">
                <label className="small font-weight-bold mb-1">Section Name</label>
                <input
                  type="text"
                  value={secName}
                  onChange={(e) => setSecName(e.target.value)}
                  className="form-control form-control-sm"
                  placeholder="e.g. Front Balcony, Section A"
                />
              </div>

              <div className="form-group mb-3">
                <label className="small font-weight-bold mb-1">Section Code / Prefix</label>
                <input
                  type="text"
                  value={secCode}
                  onChange={(e) => setSecCode(e.target.value.toUpperCase())}
                  className="form-control form-control-sm"
                  placeholder="e.g. SEC-A"
                />
              </div>

              <div className="form-group mb-3">
                <label className="small font-weight-bold mb-1">Pricing Category</label>
                <select
                  value={pricingCatId}
                  onChange={(e) => setPricingCatId(parseInt(e.target.value) || 0)}
                  className="form-control form-control-sm"
                >
                  <option value={0}>None (Default Pricing)</option>
                  {pricingCategories.map(cat => (
                    <option key={cat.id} value={cat.id}>
                      {cat.name} (₹ {cat.price})
                    </option>
                  ))}
                </select>
              </div>

              <h6 className="font-weight-bold text-muted mt-4 mb-3 uppercase">Layout Alignment</h6>
              
              <div className="btn-group btn-group-toggle w-100 mb-3" data-toggle="buttons">
                <label className={`btn btn-sm btn-outline-secondary ${layoutType === 'straight' ? 'active font-weight-bold' : ''} w-50`}>
                  <input type="radio" name="layoutType" checked={layoutType === 'straight'} onChange={() => setLayoutType('straight')} /> Straight Rows
                </label>
                <label className={`btn btn-sm btn-outline-secondary ${layoutType === 'curved' ? 'active font-weight-bold' : ''} w-50`}>
                  <input type="radio" name="layoutType" checked={layoutType === 'curved'} onChange={() => setLayoutType('curved')} /> Curved Rows
                </label>
              </div>

              {layoutType === 'curved' && (
                <div className="row">
                  <div className="col-6">
                    <div className="form-group">
                      <label className="small font-weight-bold mb-1">Arc Curve (deg)</label>
                      <input
                        type="number"
                        value={curveAngle}
                        onChange={(e) => setCurveAngle(parseInt(e.target.value) || 0)}
                        className="form-control form-control-sm"
                        min={10}
                        max={180}
                      />
                    </div>
                  </div>
                  <div className="col-6">
                    <div className="form-group">
                      <label className="small font-weight-bold mb-1">Focal Radius (px)</label>
                      <input
                        type="number"
                        value={curveRadius}
                        onChange={(e) => setCurveRadius(parseInt(e.target.value) || 100)}
                        className="form-control form-control-sm"
                        min={50}
                        max={800}
                      />
                    </div>
                  </div>
                </div>
              )}
            </div>

            {/* Column 2: Grid Rows & Column Numbers */}
            <div className="col-md-6 pl-4">
              <h6 className="font-weight-bold text-muted mb-3 uppercase">Grid Details</h6>

              <div className="row mb-3">
                <div className="col-6">
                  <label className="small font-weight-bold mb-1">Row Count</label>
                  <input
                    type="number"
                    value={rowCount}
                    onChange={(e) => setRowCount(Math.max(1, parseInt(e.target.value) || 1))}
                    className="form-control form-control-sm"
                    min={1}
                  />
                </div>
                <div className="col-6">
                  <label className="small font-weight-bold mb-1">Start Row Letter</label>
                  <input
                    type="text"
                    value={startRowLetter}
                    onChange={(e) => setStartRowLetter(e.target.value.substring(0,1).toUpperCase())}
                    className="form-control form-control-sm"
                    maxLength={1}
                  />
                </div>
              </div>

              <div className="row mb-3">
                <div className="col-6">
                  <label className="small font-weight-bold mb-1">Seats per Row</label>
                  <input
                    type="number"
                    value={seatsPerRow}
                    onChange={(e) => setSeatsPerRow(Math.max(1, parseInt(e.target.value) || 1))}
                    className="form-control form-control-sm"
                    min={1}
                  />
                </div>
                <div className="col-6">
                  <label className="small font-weight-bold mb-1">Start Seat #</label>
                  <input
                    type="number"
                    value={startSeatNum}
                    onChange={(e) => setStartSeatNum(parseInt(e.target.value) || 1)}
                    className="form-control form-control-sm"
                    min={0}
                  />
                </div>
              </div>

              <div className="row mb-3">
                <div className="col-6">
                  <label className="small font-weight-bold mb-1">Seat Spacing (px)</label>
                  <input
                    type="number"
                    value={seatSpacing}
                    onChange={(e) => setSeatSpacing(parseInt(e.target.value) || 30)}
                    className="form-control form-control-sm"
                    min={20}
                  />
                </div>
                <div className="col-6">
                  <label className="small font-weight-bold mb-1">Row Spacing (px)</label>
                  <input
                    type="number"
                    value={rowSpacing}
                    onChange={(e) => setRowSpacing(parseInt(e.target.value) || 30)}
                    className="form-control form-control-sm"
                    min={20}
                  />
                </div>
              </div>

              <div className="form-group mb-0">
                <label className="form-check-label small font-weight-bold">
                  <input
                    type="checkbox"
                    checked={reverseNumbering}
                    onChange={(e) => setReverseNumbering(e.target.checked)}
                    className="mr-1"
                  /> Reverse seat numbering (Right to Left)
                </label>
              </div>

              <div className="alert alert-light mt-4 mb-0 border py-2 px-3 small text-muted">
                Estimated Total: <strong>{rowCount * seatsPerRow} Seats</strong> will be painted.
              </div>
            </div>

          </div>

          <div className="modal-footer bg-light px-4">
            <button type="button" onClick={onClose} className="btn btn-secondary btn-sm">
              Cancel
            </button>
            <button type="button" onClick={handleGenerate} className="btn btn-primary btn-sm px-4">
              Paint Section
            </button>
          </div>

        </div>
      </div>
    </div>
  );
};

export default AutoGeneratorDialog;
