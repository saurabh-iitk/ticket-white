import React from 'react';
import * as LucideIcons from 'lucide-react';

interface ToolbarProps {
  activeTool: string;
  setActiveTool: (tool: string) => void;
  iconMapping: Record<string, string>;
  onOpenCustomizeModal: () => void;
}

const Toolbar: React.FC<ToolbarProps> = ({ 
  activeTool, 
  setActiveTool, 
  iconMapping, 
  onOpenCustomizeModal 
}) => {

  const renderIcon = (iconName: string, className?: string) => {
    const IconComponent = (LucideIcons as any)[iconName] || LucideIcons.HelpCircle;
    return <IconComponent size={20} strokeWidth={1.5} className={className} />;
  };

  const tools = [
    { id: 'select', label: 'Select & Move', icon: renderIcon(iconMapping.select || 'MousePointer2'), category: 'Canvas' },
    { id: 'eraser', label: 'Delete / Eraser', icon: renderIcon(iconMapping.eraser || 'Trash2', 'text-danger'), category: 'Canvas' },

    { id: 'seat_regular', label: 'Regular Seat', icon: renderIcon(iconMapping.seat_regular || 'Armchair', 'text-success'), category: 'Seats' },
    { id: 'seat_vip', label: 'VIP Seat', icon: renderIcon(iconMapping.seat_vip || 'Crown', 'text-warning'), category: 'Seats' },
    { id: 'seat_premium', label: 'Premium Seat', icon: renderIcon(iconMapping.seat_premium || 'Gem', 'text-primary'), category: 'Seats' },
    { id: 'seat_accessible', label: 'Accessible (Wheelchair)', icon: renderIcon(iconMapping.seat_accessible || 'Accessibility', 'text-info'), category: 'Seats' },
    { id: 'seat_companion', label: 'Companion Seat', icon: renderIcon(iconMapping.seat_companion || 'Users', 'text-secondary'), category: 'Seats' },
    { id: 'seat_blocked', label: 'Blocked / Unavailable', icon: renderIcon(iconMapping.seat_blocked || 'Ban', 'text-danger'), category: 'Seats' },

    { id: 'stage', label: 'Stage Layout', icon: renderIcon(iconMapping.stage || 'Mic', 'text-dark'), category: 'Venue Objects' },
    { id: 'entrance', label: 'Entrance Gate', icon: renderIcon(iconMapping.entrance || 'DoorOpen', 'text-success'), category: 'Venue Objects' },
    { id: 'exit', label: 'Exit Gate', icon: renderIcon(iconMapping.exit || 'DoorClosed', 'text-danger'), category: 'Venue Objects' },
    { id: 'restroom', label: 'Restroom Area', icon: renderIcon(iconMapping.restroom || 'Bath', 'text-info'), category: 'Venue Objects' },
    { id: 'bar', label: 'Bar / Cafe Area', icon: renderIcon(iconMapping.bar || 'Coffee', 'text-warning'), category: 'Venue Objects' },
    { id: 'stairs', label: 'Stairs', icon: renderIcon(iconMapping.stairs || 'Layers', 'text-secondary'), category: 'Venue Objects' },
    { id: 'label', label: 'Custom Label Text', icon: renderIcon(iconMapping.label || 'Type', 'text-dark'), category: 'Venue Objects' },
    { id: 'shape', label: 'Custom Shape / Box', icon: renderIcon(iconMapping.shape || 'Square', 'text-dark'), category: 'Venue Objects' }
  ];

  // Group tools by category
  const categories = Array.from(new Set(tools.map(t => t.category)));

  return (
    <div className="bg-light border-right h-100 py-3 px-2 d-flex flex-column gap-3 overflow-auto" style={{ width: '120px', minWidth: '120px' }}>
      {categories.map(cat => (
        <div key={cat} className="d-flex flex-column gap-1 align-items-center">
          <span className="text-muted font-weight-bold text-center uppercase" style={{ fontSize: '9px', letterSpacing: '0.4px', marginBottom: '6px' }}>
            {cat}
          </span>
          <div className="w-100" style={{ display: 'grid', gridTemplateColumns: 'repeat(2, 1fr)', gap: '6px', padding: '0 4px' }}>
            {tools.filter(t => t.category === cat).map(t => (
              <button
                key={t.id}
                onClick={() => setActiveTool(t.id)}
                className={`btn btn-sm p-0 rounded-lg d-flex align-items-center justify-content-center transition-all ${
                  activeTool === t.id 
                    ? 'btn-primary shadow-sm text-white' 
                    : 'btn-outline-secondary border-0 hover-bg-light text-muted'
                }`}
                style={{ width: '42px', height: '42px' }}
                title={t.label}
              >
                {t.icon}
              </button>
            ))}
          </div>
          <hr className="w-75 my-2" style={{ borderColor: '#e2e8f0' }} />
        </div>
      ))}
      <button 
        onClick={onOpenCustomizeModal} 
        className="btn btn-outline-secondary btn-sm w-100 mt-auto py-2 d-flex align-items-center justify-content-center border-0 font-weight-bold"
        style={{ fontSize: '11px', gap: '4px', color: '#64748b' }}
        title="Customize Toolbox Icons"
      >
        <LucideIcons.Settings size={14} strokeWidth={1.5} /> Customize
      </button>
    </div>
  );
};

export default Toolbar;
