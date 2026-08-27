export interface PricingCategory {
  id?: number;
  name: string;
  price: number;
  currency: string;
  color: string;
}

export interface Section {
  id?: number | string;
  client_id?: string; // used for unsaved section references
  name: string;
  code: string;
  capacity?: number;
  pricing_category_id?: number | null;
  color: string;
  x: number;
  y: number;
  w: number;
  h: number;
  rotation: number;
  is_locked?: boolean;
  group_id?: string;
}

export interface Seat {
  id?: number | string;
  row_no?: number | null;
  col_no?: number | null;
  name: string;
  label: string;
  seatno: string;
  section_id?: number | string | null;
  seat_type: 'REGULAR' | 'VIP' | 'PREMIUM' | 'ACCESSIBLE' | 'COMPANION' | 'BLOCKED';
  x: number;
  y: number;
  w: number;
  h: number;
  rotation: number;
  is_visible: boolean;
  is_removed: boolean;
  is_damaged: boolean;
  is_reserved: boolean;
  is_locked?: boolean;
  group_id?: string;
}

export interface Gate {
  id: string;
  type: 'stage' | 'entrance' | 'exit' | 'restroom' | 'bar' | 'stairs' | 'label' | 'shape';
  label: string;
  icon?: string;
  color: string;
  x: number;
  y: number;
  w: number;
  h: number;
  rotation: number;
  is_locked?: boolean;
  group_id?: string;
  font_family?: string;
  font_size?: number;
  font_style?: string;
  text_decoration?: string;
  border_radius?: number;
}

export interface CanvasState {
  sections: Section[];
  seats: Seat[];
  gates: Gate[];
  layoutName: string;
}
