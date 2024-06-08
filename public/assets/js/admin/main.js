// Encapsulate the slider functionality in a function
function initializeSlider() {
    let slider = document.querySelector('.slider .list');
    let items = document.querySelectorAll('.slider .list .item');
    let next = document.getElementById('next');
    let prev = document.getElementById('prev');
    let dots = document.querySelectorAll('.slider .dots li');

    let lengthItems = items.length - 1;
    let active = 0;

    next.onclick = function () {
        active = active + 1 <= lengthItems ? active + 1 : 0;
        reloadSlider();
    }

    prev.onclick = function () {
        active = active - 1 >= 0 ? active - 1 : lengthItems;
        reloadSlider();
    }

    let refreshInterval = setInterval(() => { next.click() }, 3000);

    function reloadSlider() {
        slider.style.left = -items[active].offsetLeft + 'px';

        let last_active_dot = document.querySelector('.slider .dots li.active');
        if (last_active_dot) {
            last_active_dot.classList.remove('active');
        }

        dots[active].classList.add('active');

        clearInterval(refreshInterval);
        refreshInterval = setInterval(() => { next.click() }, 3000);
    }

    dots.forEach((li, key) => {
        li.addEventListener('click', () => {
            active = key;
            reloadSlider();
        })
    });

    window.onresize = function (event) {
        reloadSlider();
    };
}

// Call the initializeSlider function only when needed
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.slider .list')) {
        initializeSlider();
    }
});

// end slider login

// start show password 

const passwordIcon = document.querySelectorAll('.password__icon');
const authPassword = document.querySelectorAll('.auth__password');

for (let i = 0; i < passwordIcon.length; ++i) {
    passwordIcon[i].addEventListener('click', (event) => {
        const inputField = event.currentTarget.parentElement.querySelector('input');
        if (event.target.classList.contains('fa-eye-slash')) {
            event.target.classList.remove('fa-eye-slash');
            event.target.classList.add('fa-eye');
            inputField.type = 'text';
        } else {
            event.target.classList.add('fa-eye-slash');
            event.target.classList.remove('fa-eye');
            inputField.type = 'password';
        }
    });
}


// end show password 


// start page add job

//check any option select selected and add class to select input 
document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('job-status');

    function updateClass() {
        if (selectElement.value === 'active') {
            selectElement.classList.add('border-green-600');
            selectElement.classList.remove('border-red-600');
            selectElement.classList.remove('dark:border-gray-600');
        } else if (selectElement.value === 'inactive') {
            selectElement.classList.add('border-red-600');
            selectElement.classList.remove('border-green-600');
            selectElement.classList.remove('dark:border-gray-600');
        } else {
            selectElement.classList.add('dark:border-gray-600');
        }
    }

    // Initial class update
    updateClass();

    // Update class on change
    selectElement.addEventListener('change', updateClass);
});

// end page add job
