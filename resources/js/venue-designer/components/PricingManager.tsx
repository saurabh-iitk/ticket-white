import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { PricingCategory } from '../types.ts';
import { Trash2, Save, X, Edit3 } from 'lucide-react';

interface PricingManagerProps {
  categories: PricingCategory[];
  onClose: () => void;
}

const getBasePath = () => {
  const index = window.location.pathname.indexOf('/layout/designer/');
  return index !== -1 ? window.location.pathname.substring(0, index) : '';
};
const basePath = getBasePath();

const PricingManager: React.FC<PricingManagerProps> = ({ categories, onClose }) => {
  const [list, setList] = useState<PricingCategory[]>(categories);
  const [editingId, setEditingId] = useState<number | null | undefined>(null);
  
  // Form State
  const [name, setName] = useState<string>('');
  const [price, setPrice] = useState<number>(0);
  const [currency, setCurrency] = useState<string>('INR');
  const [color, setColor] = useState<string>('#3b82f6');
  
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    fetchList();
  }, []);

  const fetchList = async () => {
    try {
      const res = await axios.get(`${basePath}/layout/designer/pricing-categories/list`);
      setList(res.data);
    } catch(err) {
      setError('Could not retrieve pricing tiers.');
    }
  };

  const handleEditClick = (cat: PricingCategory) => {
    setEditingId(cat.id);
    setName(cat.name);
    setPrice(cat.price);
    setCurrency(cat.currency);
    setColor(cat.color);
  };

  const handleResetForm = () => {
    setEditingId(null);
    setName('');
    setPrice(0);
    setCurrency('INR');
    setColor('#3b82f6');
    setError(null);
  };

  const handleSave = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim()) {
      setError('Pricing name is required.');
      return;
    }
    if (price < 0) {
      setError('Price cannot be negative.');
      return;
    }

    setLoading(true);
    setError(null);

    const payload = {
      id: editingId || undefined,
      name,
      price,
      currency,
      color
    };

    try {
      await axios.post(`${basePath}/layout/designer/pricing-categories/store`, payload);
      await fetchList();
      handleResetForm();
    } catch(err) {
      setError('Failed to save pricing category.');
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id?: number) => {
    if (!id) return;
    if (!confirm('Are you sure you want to delete this pricing category? Any sections or seats referencing it will lose their pricing assignments.')) return;

    setLoading(true);
    try {
      await axios.delete(`${basePath}/layout/designer/pricing-categories/${id}/delete`);
      await fetchList();
    } catch(err) {
      setError('Failed to delete pricing category.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="modal fade show d-block" style={{ backgroundColor: 'rgba(0,0,0,0.5)', zIndex: 1050 }} tabIndex={-1}>
      <div className="modal-dialog modal-lg modal-dialog-centered">
        <div className="modal-content shadow-lg border-0 rounded-lg">
          
          <div className="modal-header bg-dark text-white rounded-top px-4">
            <h5 className="modal-title font-weight-bold d-flex align-items-center">
              <Tag className="mr-2 text-primary" size={20} />
              Pricing Category Manager
            </h5>
            <button type="button" onClick={onClose} className="close text-white" aria-label="Close">
              <X size={20} />
            </button>
          </div>

          <div className="modal-body p-4 row">
            
            {/* Left side: Create/Edit Form */}
            <div className="col-md-5 border-right pr-4">
              <h6 className="font-weight-bold text-muted mb-3 uppercase">
                {editingId ? 'Edit Pricing Category' : 'Create Pricing Category'}
              </h6>
              
              {error && <div className="alert alert-danger py-2 px-3 small">{error}</div>}

              <form onSubmit={handleSave} className="d-flex flex-column gap-3">
                <div className="form-group mb-2">
                  <label className="small font-weight-bold mb-1">Category Name</label>
                  <input
                    type="text"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    className="form-control form-control-sm"
                    placeholder="e.g. VIP Gold, Early Bird"
                  />
                </div>

                <div className="form-group mb-2">
                  <label className="small font-weight-bold mb-1">Base Price</label>
                  <div className="input-group input-group-sm">
                    <div className="input-group-prepend">
                      <span className="input-group-text">₹</span>
                    </div>
                    <input
                      type="number"
                      value={price}
                      onChange={(e) => setPrice(parseFloat(e.target.value) || 0)}
                      className="form-control"
                      min={0}
                    />
                  </div>
                </div>

                <div className="form-group mb-2">
                  <label className="small font-weight-bold mb-1">Theme Color</label>
                  <input
                    type="color"
                    value={color}
                    onChange={(e) => setColor(e.target.value)}
                    className="form-control form-control-sm py-0"
                    style={{ height: '32px' }}
                  />
                </div>

                <div className="d-flex gap-2 mt-3">
                  <button type="submit" disabled={loading} className="btn btn-primary btn-sm flex-grow-1 d-flex align-items-center justify-content-center">
                    <Save size={14} className="mr-1" /> {editingId ? 'Update Tier' : 'Add Category'}
                  </button>
                  {editingId && (
                    <button type="button" onClick={handleResetForm} className="btn btn-outline-secondary btn-sm">
                      Cancel
                    </button>
                  )}
                </div>
              </form>
            </div>

            {/* Right side: List of Pricing tiers */}
            <div className="col-md-7 pl-4 overflow-auto" style={{ maxHeight: '380px' }}>
              <h6 className="font-weight-bold text-muted mb-3 uppercase">
                Active Pricing Categories
              </h6>
              
              {list.length === 0 ? (
                <p className="text-muted small text-center py-4">No categories configured yet.</p>
              ) : (
                <div className="d-flex flex-column gap-2">
                  {list.map(cat => (
                    <div key={cat.id} className="d-flex align-items-center justify-content-between p-2 border rounded-lg hover-bg-light shadow-sm" style={{ borderLeft: `4px solid ${cat.color} !important` }}>
                      <div className="d-flex align-items-center">
                        <span className="mr-3 rounded-circle" style={{ width: '14px', height: '14px', backgroundColor: cat.color }}></span>
                        <div>
                          <strong style={{ fontSize: '14px' }}>{cat.name}</strong> <br />
                          <span className="text-muted small">₹ {cat.price} {cat.currency}</span>
                        </div>
                      </div>
                      <div className="d-flex gap-1">
                        <button onClick={() => handleEditClick(cat)} className="btn btn-outline-info btn-xs p-1" title="Edit"><Edit3 size={12} /></button>
                        <button onClick={() => handleDelete(cat.id)} className="btn btn-outline-danger btn-xs p-1" title="Delete"><Trash2 size={12} /></button>
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>

          </div>

          <div className="modal-footer bg-light px-4">
            <button type="button" onClick={onClose} className="btn btn-secondary btn-sm">
              Close Manager
            </button>
          </div>

        </div>
      </div>
    </div>
  );
};

// SVG tag helper
const Tag: React.FC<{ className?: string; size?: number }> = ({ className, size = 16 }) => (
  <svg xmlns="http://www.w3.org/2000/svg" width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className}>
    <path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.41 2.41 0 0 0 3.405 0l5.889-5.889a2.41 2.41 0 0 0 0-3.405l-8.704-8.704z"></path>
    <line x1="7" y1="7" x2="7.01" y2="7"></line>
  </svg>
);

export default PricingManager;
