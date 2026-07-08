window.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('graph-bg');

    if (!canvas) {
        return;
    }

    const engine = new GraphEngine(canvas);
    engine.start();
});
