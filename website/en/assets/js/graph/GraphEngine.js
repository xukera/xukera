class GraphEngine {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');

        this.width = 0;
        this.height = 0;
        this.nodes = [];
        this.activatedEdges = new Map();
        this.mouse = { x: null, y: null };
        this.pulse = new Pulse();
    }

    start() {
        this.resize();
        this.bindEvents();
        this.draw();
    }

    bindEvents() {
        window.addEventListener('resize', () => this.resize());

        window.addEventListener('mousemove', (event) => {
            this.mouse.x = event.clientX;
            this.mouse.y = event.clientY;
        });

        window.addEventListener('mouseleave', () => {
            this.mouse.x = null;
            this.mouse.y = null;
        });
    }

    resize() {
        this.width = this.canvas.width = window.innerWidth;
        this.height = this.canvas.height = window.innerHeight;
        this.createNodes();
    }

    createNodes() {
        const count = Math.min(95, Math.floor((this.width * this.height) / 17000));
        this.nodes = [];
        this.activatedEdges.clear();

        for (let i = 0; i < count; i++) {
            this.nodes.push(new GraphNode(
                Math.random() * this.width,
                Math.random() * this.height,
                (Math.random() - 0.5) * 0.25,
                (Math.random() - 0.5) * 0.25,
                Math.random() * 1.8 + 1.1
            ));
        }

        this.pulse.reset(this.nodes.length);

        if (this.nodes[0]) {
            this.nodes[0].energy = 1;
        }
    }

    edgeKey(a, b) {
        return a < b ? `${a}-${b}` : `${b}-${a}`;
    }

    distance(a, b) {
        const dx = a.x - b.x;
        const dy = a.y - b.y;
        return Math.sqrt(dx * dx + dy * dy);
    }

    nearestUnvisitedNode(fromIndex) {
        let bestIndex = null;
        let bestDistance = Infinity;

        for (let i = 0; i < this.nodes.length; i++) {
            if (i === fromIndex || this.pulse.visited.has(i)) {
                continue;
            }

            const d = this.distance(this.nodes[fromIndex], this.nodes[i]);

            if (d < bestDistance) {
                bestDistance = d;
                bestIndex = i;
            }
        }

        if (bestIndex === null) {
            this.pulse.visited.clear();
            bestIndex = Math.floor(Math.random() * this.nodes.length);
        }

        return bestIndex;
    }

    updatePulse() {
        if (!this.pulse.active || this.nodes.length < 2) {
            return;
        }

        this.pulse.progress += this.pulse.speed;

        if (this.pulse.progress >= 1) {
            const key = this.edgeKey(this.pulse.current, this.pulse.target);

            this.activatedEdges.set(key, {
                a: this.pulse.current,
                b: this.pulse.target,
                energy: 1
            });

            this.pulse.current = this.pulse.target;
            this.pulse.visited.add(this.pulse.current);

            this.nodes[this.pulse.current].energy = 1.4;

            this.pulse.target = this.nearestUnvisitedNode(this.pulse.current);
            this.pulse.progress = 0;
        }
    }

    drawAmbientConnections() {
        for (let i = 0; i < this.nodes.length; i++) {
            const a = this.nodes[i];

            for (let j = i + 1; j < this.nodes.length; j++) {
                const b = this.nodes[j];
                const d = this.distance(a, b);

                if (d < 150) {
                    const opacity = (1 - d / 150) * 0.11;

                    this.ctx.strokeStyle = `rgba(56, 189, 248, ${opacity})`;
                    this.ctx.lineWidth = 1;

                    this.ctx.beginPath();
                    this.ctx.moveTo(a.x, a.y);
                    this.ctx.lineTo(b.x, b.y);
                    this.ctx.stroke();
                }
            }
        }
    }

    drawActivatedEdges() {
        this.activatedEdges.forEach((edge) => {
            const a = this.nodes[edge.a];
            const b = this.nodes[edge.b];

            if (!a || !b) {
                return;
            }

            edge.energy *= 0.996;

            const opacity = Math.max(0.08, edge.energy * 0.38);

            this.ctx.strokeStyle = `rgba(103, 232, 249, ${opacity})`;
            this.ctx.lineWidth = 1.8;
            this.ctx.shadowColor = 'rgba(34, 211, 238, 0.75)';
            this.ctx.shadowBlur = edge.energy * 16;

            this.ctx.beginPath();
            this.ctx.moveTo(a.x, a.y);
            this.ctx.lineTo(b.x, b.y);
            this.ctx.stroke();

            this.ctx.shadowBlur = 0;
        });
    }

    drawPulse() {
        if (!this.pulse.active || this.nodes.length < 2) {
            return;
        }

        const from = this.nodes[this.pulse.current];
        const to = this.nodes[this.pulse.target];

        const x = from.x + (to.x - from.x) * this.pulse.progress;
        const y = from.y + (to.y - from.y) * this.pulse.progress;

        this.ctx.strokeStyle = 'rgba(125, 211, 252, 0.9)';
        this.ctx.lineWidth = 4;
        this.ctx.shadowColor = 'rgba(34, 211, 238, 0.95)';
        this.ctx.shadowBlur = 22;

        this.ctx.beginPath();
        this.ctx.moveTo(from.x, from.y);
        this.ctx.lineTo(x, y);
        this.ctx.stroke();

        this.ctx.fillStyle = 'rgba(224, 242, 254, 0.98)';
        this.ctx.beginPath();
        this.ctx.arc(x, y, 6, 0, Math.PI * 2);
        this.ctx.fill();

        this.ctx.shadowBlur = 0;
    }

    drawMouseConnection(node) {
        if (this.mouse.x === null) {
            return;
        }

        const dx = node.x - this.mouse.x;
        const dy = node.y - this.mouse.y;
        const d = Math.sqrt(dx * dx + dy * dy);

        if (d < 180) {
            this.ctx.strokeStyle = `rgba(125, 211, 252, ${(1 - d / 180) * 0.45})`;
            this.ctx.beginPath();
            this.ctx.moveTo(node.x, node.y);
            this.ctx.lineTo(this.mouse.x, this.mouse.y);
            this.ctx.stroke();
        }
    }

    drawNodes() {
        for (const node of this.nodes) {
            node.move(this.width, this.height);

            this.drawMouseConnection(node);

            const alpha = Math.max(0.42, 0.72 + node.energy * 0.26);
            const radius = node.r + node.energy * 3.2;

            this.ctx.fillStyle = `rgba(125, 211, 252, ${alpha})`;
            this.ctx.shadowColor = 'rgba(34, 211, 238, 0.85)';
            this.ctx.shadowBlur = node.energy * 22;

            this.ctx.beginPath();
            this.ctx.arc(node.x, node.y, radius, 0, Math.PI * 2);
            this.ctx.fill();

            this.ctx.shadowBlur = 0;
        }
    }

    draw() {
        this.ctx.clearRect(0, 0, this.width, this.height);

        this.updatePulse();

        this.drawAmbientConnections();
        this.drawActivatedEdges();
        this.drawNodes();
        this.drawPulse();

        requestAnimationFrame(() => this.draw());
    }
}

window.GraphEngine = GraphEngine;
