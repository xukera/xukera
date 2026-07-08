class IntroDirector {
    constructor() {
        this.intro = document.getElementById('intro');
        this.button = document.querySelector('.intro-button');
        this.text = document.querySelector('.intro-text');
    }

    start() {
        if (!this.intro) {
            return;
        }

        document.body.classList.add('intro-running');

        setTimeout(() => {
            this.showText();
        }, 600);

        setTimeout(() => {
            this.showButton();
        }, 3200);
    }

    showText() {
        if (this.text) {
            this.text.classList.add('visible');
        }
    }

    showButton() {
        if (this.button) {
            this.button.classList.add('visible');
        }
    }

    enter() {
        if (!this.intro) {
            return;
        }

        this.intro.classList.add('hidden');
        document.body.classList.remove('intro-running');
        document.body.classList.add('intro-complete');
    }
}

window.IntroDirector = IntroDirector;
