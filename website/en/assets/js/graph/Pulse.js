class Pulse {
    constructor() {
        this.active = true;
        this.current = 0;
        this.target = 1;
        this.progress = 0;
        this.speed = 0.018;
        this.visited = new Set();
    }

    reset(nodeCount) {
        this.current = 0;
        this.target = Math.min(1, nodeCount - 1);
        this.progress = 0;
        this.visited = new Set([0]);
    }
}

window.Pulse = Pulse;
