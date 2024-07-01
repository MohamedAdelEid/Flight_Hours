
// --------------------------------------- Employee -------------------------------------


//check any option select selected and add class to select input 
document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('job-status');

    if (selectElement) {
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
        updateClass();
        selectElement.addEventListener('change', updateClass);
    }
});


// ************************************************


// select ToAirportGoing -> FromAirportBack 
document.addEventListener('DOMContentLoaded', function () {
    var toAirportGoing = document.querySelector('#to-airport-going');
    var fromAirportBack = document.querySelector('#from-airport-back');

    if (toAirportGoing) {
        toAirportGoing.addEventListener('change', function () {
            fromAirportBack.value = toAirportGoing.value;
        });
    }
});


// ************************************************ 