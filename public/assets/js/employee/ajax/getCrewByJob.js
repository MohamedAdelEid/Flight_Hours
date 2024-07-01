
// Attach change event listeners to each job_id dropdown

document.addEventListener('DOMContentLoaded', function () {
    var submitOfCrew = document.querySelector('#submit-num-of-crew');
    var numOfCrew = document.querySelector('#num-of-crew');
    var numberOfCrew = parseInt(numOfCrew.value);

    submitOfCrew.onclick = function () {
        numberOfCrew = parseInt(numOfCrew.value);
        updateCrew(numberOfCrew);
    };

    function updateCrew(numberOfCrew) {
        for (let j = 1; j <= numberOfCrew; j++) {
            $(`.submit-financial-num-${j}`).click(function () {
                var financialNumber = $(`.financial-number-${j}`).val();
                var crewName = $(`.crew-name-${j}`);
                var crewJobType = $(`.crew-job-type-${j}`);

                if (financialNumber) {
                    $.ajax({
                        url: '/crew-by-financial-number/' + financialNumber,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {

                            if (data.length > 0) {
                                var crew = data[0];

                                crewName.empty();
                                crewJobType.empty();
                                
                                crewName.removeClass('text-red-500');
                                crewName.addClass('text-green-500');
                                crewJobType.addClass('text-green-500');

                                crewName.append(crewName.text(crew.first_name + ' ' + crew.last_name));
                                crewJobType.append(crewJobType.text(crew.job_name));
                            } else {
                                crewName.empty();
                                crewJobType.empty();

                                crewName.removeClass('text-green-500');
                                crewName.addClass('text-red-500');
                                crewName.append(crewName.text('الرقم المالي غير صحيح !'))
                            }
                        },
                        error: function (xhr, status, error) {
                            crewName.append(crewName.text('تاكد من اتصال الانترنت'))
                        }
                    });
                } else {
                    crewName.empty();
                    crewJobType.empty();

                    crewName.removeClass('text-green-500');
                    crewName.addClass('text-red-500');
                    crewName.append('ادخل الرقم المالي أولا');
                }
            });
        }
    }
    updateCrew(numberOfCrew);
});
