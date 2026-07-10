class Node {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        this.radius = 2;
        this.alpha = 0;
        this.pulse = 0;
    }

    update() {
        this.alpha = Math.min(1, this.alpha + 0.008);
        this.pulse += 0.04;
    }

    draw(ctx) {
        const glow = 8 + Math.sin(this.pulse) * 4;

        ctx.save();
        ctx.globalAlpha = this.alpha;
        ctx.shadowColor = "rgba(34, 211, 238, 0.9)";
        ctx.shadowBlur = glow;
        ctx.fillStyle = "rgba(125, 211, 252, 1)";

        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fill();

        ctx.restore();
    }
}

window.Node = Node;
