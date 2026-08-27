import React, { useState } from 'react';
import * as LucideIcons from 'lucide-react';
import { X, RotateCcw, Save } from 'lucide-react';

interface CustomizeToolboxDialogProps {
  onClose: () => void;
  iconMapping: Record<string, string>;
  onSave: (newMapping: Record<string, string>) => void;
}

const EDITABLE_TOOLS = [
  { id: 'seat_regular', label: 'Regular Seat', defaultIcon: 'Armchair' },
  { id: 'seat_vip', label: 'VIP Seat', defaultIcon: 'Crown' },
  { id: 'seat_premium', label: 'Premium Seat', defaultIcon: 'Gem' },
  { id: 'seat_accessible', label: 'Accessible (Wheelchair)', defaultIcon: 'Accessibility' },
  { id: 'seat_companion', label: 'Companion Seat', defaultIcon: 'Users' },
  { id: 'seat_blocked', label: 'Blocked / Unavailable', defaultIcon: 'Ban' },
  { id: 'stage', label: 'Stage Layout', defaultIcon: 'Mic' },
  { id: 'entrance', label: 'Entrance Gate', defaultIcon: 'DoorOpen' },
  { id: 'exit', label: 'Exit Gate', defaultIcon: 'DoorClosed' },
  { id: 'restroom', label: 'Restroom Area', defaultIcon: 'Bath' },
  { id: 'bar', label: 'Bar / Cafe Area', defaultIcon: 'Coffee' },
  { id: 'stairs', label: 'Stairs', defaultIcon: 'Layers' },
  { id: 'label', label: 'Custom Label Text', defaultIcon: 'Type' },
  { id: 'shape', label: 'Custom Shape / Box', defaultIcon: 'Square' }
];

const AVAILABLE_ICONS = [
  'Armchair', 'Crown', 'Gem', 'Accessibility', 'Users', 'Ban', 
  'Mic', 'DoorOpen', 'DoorClosed', 'Bath', 'Coffee', 'Layers', 
  'Type', 'Square', 'Ticket', 'Star', 'MapPin', 'Activity', 
  'Heart', 'Info', 'Home', 'Tv', 'Phone', 'Calendar', 'Music', 'Smile', 'Settings'
];

const CustomizeToolboxDialog: React.FC<CustomizeToolboxDialogProps> = ({ onClose, iconMapping, onSave }) => {
  const [localMapping, setLocalMapping] = useState<Record<string, string>>({ ...iconMapping });

  const handleIconChange = (toolId: string, newIcon: string) => {
    setLocalMapping(prev => ({
      ...prev,
      [toolId]: newIcon
    }));
  };

  const handleReset = () => {
    const defaultMapping: Record<string, string> = {
      select: 'MousePointer2',
      eraser: 'Trash2'
    };
    EDITABLE_TOOLS.forEach(tool => {
      defaultMapping[tool.id] = tool.defaultIcon;
    });
    setLocalMapping(defaultMapping);
  };

  const handleSave = () => {
    onSave(localMapping);
  };

  // Helper to render icon by name
  const renderIconPreview = (iconName: string) => {
    const IconComponent = (LucideIcons as any)[iconName] || LucideIcons.HelpCircle;
    return <IconComponent size={18} strokeWidth={1.5} className="text-muted" />;
  };

  return (
    <div className="position-fixed w-100 h-100 top-0 left-0 d-flex align-items-center justify-content-center" style={{ zIndex: 9999999, background: 'rgba(15, 23, 42, 0.45)', backdropFilter: 'blur(4px)' }}>
      <div className="bg-white rounded-lg shadow-lg border overflow-hidden d-flex flex-column" style={{ width: '580px', maxHeight: '85vh', borderRadius: '12px' }}>
        
        {/* Header */}
        <div className="px-4 py-3 border-bottom d-flex align-items-center justify-content-between bg-light">
          <div className="d-flex align-items-center gap-2">
            <span className="font-weight-bold text-dark h5 mb-0">Customize Toolbox Icons</span>
          </div>
          <button onClick={onClose} className="btn btn-link text-muted p-0 border-0" style={{ fontSize: '20px', lineHeight: 1 }}>
            <X size={20} strokeWidth={1.5} />
          </button>
        </div>

        {/* Content */}
        <div className="px-4 py-3 overflow-auto flex-grow-1" style={{ fontSize: '13px' }}>
          <p className="text-muted mb-4">Choose which outline icons are displayed in your toolbox for seats, section components, and objects. Select an icon from the list to see a live preview.</p>
          
          <div className="row">
            {EDITABLE_TOOLS.map(tool => (
              <div key={tool.id} className="col-md-6 mb-3">
                <div className="card p-2 bg-light border-0 rounded d-flex flex-column gap-1">
                  <span className="font-weight-bold text-dark" style={{ fontSize: '11px' }}>{tool.label}</span>
                  <div className="d-flex align-items-center gap-2 mt-1">
                    <div className="bg-white border rounded p-2 d-flex align-items-center justify-content-center" style={{ width: '36px', height: '36px' }}>
                      {renderIconPreview(localMapping[tool.id] || tool.defaultIcon)}
                    </div>
                    <select
                      value={localMapping[tool.id] || tool.defaultIcon}
                      onChange={(e) => handleIconChange(tool.id, e.target.value)}
                      className="form-control form-control-sm flex-grow-1"
                      style={{ fontSize: '12px' }}
                    >
                      {AVAILABLE_ICONS.map(icon => (
                        <option key={icon} value={icon}>{icon}</option>
                      ))}
                    </select>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Footer */}
        <div className="px-4 py-3 border-top bg-light d-flex align-items-center justify-content-between">
          <button onClick={handleReset} className="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 font-weight-bold">
            <RotateCcw size={14} strokeWidth={1.5} /> Reset to Defaults
          </button>
          <div className="d-flex gap-2">
            <button onClick={onClose} className="btn btn-link btn-sm text-secondary font-weight-bold">Cancel</button>
            <button onClick={handleSave} className="btn btn-primary btn-sm d-flex align-items-center gap-1 font-weight-bold px-3">
              <Save size={14} strokeWidth={1.5} /> Save Changes
            </button>
          </div>
        </div>

      </div>
    </div>
  );
};

export default CustomizeToolboxDialog;
