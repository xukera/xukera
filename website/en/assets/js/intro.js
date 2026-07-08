const introDirector = new IntroDirector();

function enterSite() {
    introDirector.enter();
}

window.addEventListener('DOMContentLoaded', () => {
    introDirector.start();
});
