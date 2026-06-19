<script>
    document.addEventListener('DOMContentLoaded', function() {
        var numOfCrew = document.querySelector('#num-of-crew');
        var submitOfCrew = document.querySelector('#submit-num-of-crew');
        var divInputsCrew = document.querySelector('#icontainer-inputs-crew');

        var savedNumberOfCrew = localStorage.getItem('numOfCrew');
        if (savedNumberOfCrew) {
            numOfCrew.value = savedNumberOfCrew;
            {{ $typeFlight }}(parseInt(savedNumberOfCrew));
        }

        submitOfCrew.addEventListener('click', function(event) {
            event.preventDefault();
            var numberOfCrew = parseInt(numOfCrew.value);
            if (isNaN(numberOfCrew) || numberOfCrew < 0) {
                alert('Please enter a valid number greater than 0.');
                return;
            }
            localStorage.setItem('numOfCrew', numberOfCrew);
            {{ $typeFlight }}(numberOfCrew);
        });

        function buildCrewSelect(id) {
            var html = '<select name="financial_number[]" onchange="updateJobOptions(' + id + ')" required class="financial-number-' + id +
                ' block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 dark:text-gray-300 form-input">';
            html += '<option value="">اختر الرقم المالي ...</option>';
            if (window.allCrews) {
                for (var i = 0; i < window.allCrews.length; i++) {
                    var c = window.allCrews[i];
                    html += '<option value="' + c.financial_number + '">' +
                        c.financial_number + ' - ' + c.first_name + ' ' + c.last_name +
                        (c.job ? ' (' + c.job.job_name + ')' : '') +
                        '</option>';
                }
            }
            html += '</select>';
            return html;
        }

        function buildJobSelect(id) {
            var html = '<select name="job_id[]" required class="job-select-' + id +
                ' block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 dark:text-gray-300 form-input">';
            html += '<option value="">اختر الوظيفة ...</option>';
            html += '</select>';
            return html;
        }

        function mainFlight(numberOfCrew) {
            var htmlContent = '';
            for (var j = 1; j <= numberOfCrew; j++) {
                htmlContent +=
                    '<div class="block md:flex lg:flex xl:flex items-center mb-3 rounded-md border border-stroke py-5 px-2.5 shadow-1 dark:border-gray-600">' +
                        '<div class="w-full me-2">' +
                            '<label class="text-gray-700 dark:text-white block text-lg">الرقم المالي' +
                                buildCrewSelect(j) +
                                '@error("financial_number")<span class="text-xs text-red-600 dark:text-red-400 ms-3">{{ $message }}</span>@enderror' +
                            '</label>' +
                        '</div>' +
                        '<div class="w-full me-2">' +
                            '<label class="text-gray-700 dark:text-white block text-lg">وظيفته علي الطائرة' +
                                buildJobSelect(j) +
                                '@error("job_id")<span class="text-xs text-red-600 dark:text-red-400 ms-3">{{ $message }}</span>@enderror' +
                            '</label>' +
                        '</div>' +
                    '</div>';
            }
            if (divInputsCrew) {
                divInputsCrew.innerHTML = htmlContent;
            }
        }

        function subFlight(numberOfCrew) {
            var htmlContent = '';
            for (var j = 1; j <= numberOfCrew; j++) {
                htmlContent +=
                    '<div class="rounded-md border border-stroke shadow-1 dark:border-gray-600 mb-3">' +
                        '<div class="block md:flex lg:flex xl:flex items-center mb-1 py-5 px-2.5">' +
                            '<div class="w-full me-2">' +
                                '<label class="text-gray-700 dark:text-white block text-lg">الرقم المالي' +
                                    buildCrewSelect(j) +
                                    '@error("financial_number")<span class="text-xs text-red-600 dark:text-red-400 ms-3">{{ $message }}</span>@enderror' +
                                '</label>' +
                            '</div>' +
                            '<div class="w-full me-2">' +
                                '<label class="text-gray-700 dark:text-white block text-lg">وظيفته علي الطائرة' +
                                    buildJobSelect(j) +
                                    '@error("job_id")<span class="text-xs text-red-600 dark:text-red-400 ms-3">{{ $message }}</span>@enderror' +
                                '</label>' +
                            '</div>' +
                        '</div>' +
                        '<div class="lg:flex xl:flex md:block items-center mb-5 px-2.5">' +
                            '<div class="w-full lg:me-1">' +
                                '<label class="text-gray-700 dark:text-white block text-lg"> بداية التدريب' +
                                    '<input name="training_start_at[]" type="time" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />' +
                                '</label>' +
                            '</div>' +
                            '<div class="w-full lg:ms-1 mt-3 lg:mt-0">' +
                                '<label class="block text-xl">' +
                                    '<span class="text-gray-700 dark:text-white block">نهاية التدريب</span>' +
                                    '<input name="training_end_at[]" type="time" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />' +
                                '</label>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
            }
            if (divInputsCrew) {
                divInputsCrew.innerHTML = htmlContent;
            }
        }
    });

    function updateJobOptions(id) {
        var financialNumber = document.querySelector('.financial-number-' + id).value;
        var jobSelect = document.querySelector('.job-select-' + id);

        var crew = null;
        if (financialNumber && window.allCrews) {
            for (var i = 0; i < window.allCrews.length; i++) {
                if (window.allCrews[i].financial_number === financialNumber) {
                    crew = window.allCrews[i];
                    break;
                }
            }
        }

        var typeId = crew && crew.job ? crew.job.type_id : null;

        jobSelect.innerHTML = '<option value="">اختر الوظيفة ...</option>';

        if (window.allJobs && typeId !== null) {
            for (var i = 0; i < window.allJobs.length; i++) {
                var j = window.allJobs[i];
                if (j.type_id === typeId) {
                    var option = document.createElement('option');
                    option.value = j.id;
                    option.textContent = j.job_name;
                    jobSelect.appendChild(option);
                }
            }
        }

        if (crew && crew.job) {
            jobSelect.value = crew.job.id;
        }
    }
</script>