class Engine {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        this.ctx = this.canvas.getContext("2d");

        this.nodes = [];
        this.startedAt = performance.now();

        this.resize();

        window.addEventListener("resize", () => this.resize());
    }

    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }

    start() {
        console.log("Engine started");

        this.createFirstNode();

        requestAnimationFrame(() => this.loop());


    }
createFirstNode() {

    console.log("Creating first node");

    const x = this.canvas.width * 0.52;
    const y = this.canvas.height * 0.46;

    this.nodes.push(new Node(x, y));

    console.log(this.nodes);

    }

    loop() {
        this.ctx.fillStyle = "#000";
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

        for (const node of this.nodes) {
            node.update();
            node.draw(this.ctx);

        requestAnimationFrame(() => this.loop());
    }
}
