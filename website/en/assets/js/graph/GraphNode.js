class GraphNode {
    constructor(x, y, vx, vy, r) {
        this.x = x;
        this.y = y;
        this.vx = vx;
        this.vy = vy;
        this.r = r;
        this.energy = 0;
    }

    move(width, height) {
        this.x += this.vx;
        this.y += this.vy;

        if (this.x < 0 || this.x > width) {
            this.vx *= -1;
        }

        if (this.y < 0 || this.y > height) {
            this.vy *= -1;
        }

        this.energy *= 0.982;
    }
}

window.GraphNode = GraphNode;
