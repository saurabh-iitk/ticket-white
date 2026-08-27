import { CanvasState } from '../types';

export class HistoryManager {
  private undoStack: CanvasState[] = [];
  private redoStack: CanvasState[] = [];
  private currentState: CanvasState | null = null;

  constructor(initialState?: CanvasState) {
    if (initialState) {
      this.currentState = this.cloneState(initialState);
    }
  }

  public push(state: CanvasState) {
    if (this.currentState) {
      this.undoStack.push(this.cloneState(this.currentState));
    }
    this.currentState = this.cloneState(state);
    this.redoStack = [];
  }

  public undo(): CanvasState | null {
    if (this.undoStack.length === 0) return null;
    const previous = this.undoStack.pop()!;
    if (this.currentState) {
      this.redoStack.push(this.cloneState(this.currentState));
    }
    this.currentState = previous;
    return this.currentState;
  }

  public redo(): CanvasState | null {
    if (this.redoStack.length === 0) return null;
    const next = this.redoStack.pop()!;
    if (this.currentState) {
      this.undoStack.push(this.cloneState(this.currentState));
    }
    this.currentState = next;
    return this.currentState;
  }

  public canUndo(): boolean {
    return this.undoStack.length > 0;
  }

  public canRedo(): boolean {
    return this.redoStack.length > 0;
  }

  private cloneState(state: CanvasState): CanvasState {
    return JSON.parse(JSON.stringify(state));
  }
}
