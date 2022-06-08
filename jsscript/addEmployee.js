
$(function () {
    $('.skillBtn_wrapper').on('click', function (e) {
    e.preventDefault();
    $('.skillsRes').append('<div class="gen_wrapper skillsRow" >\n' +
        '                <div>\n' +
        '                    <div class="sub_title">Skill</div>\n' +
        '                    <div><input class="genInputField" id="skill" type="text" name="ClientInfo[skill][]" placeholder="Skill" required></div>\n' +
        '                </div>\n' +
        '                <div>\n' +
        '                    <div class="sub_title">Yrs Exp</div>\n' +
        '                    <div><input class="genInputField" id="exp" type="text" name="ClientInfo[exp][]" placeholder="Yrs Exp" required></div>\n' +
        '                </div>\n' +
        '                <div>\n' +
        '                    <div class="sub_title">Seniority Rating</div>\n' +
        '                    <div class="selectBtn_wrapper">\n' +
        '                        <select class="genSelect"  name="ClientInfo[rating][]" id="rating" required>\n' +
        '                            <option value="Beginner">Beginner</option>\n' +
        '                            <option value="Intermediate">Intermediate</option>\n' +
        '                            <option value="Expert">Expert</option>\n' +
        '                        </select>\n' +
        '                        <div class="removeSkillBtn">\n' +
        '                            <div><img src="images/remove.svg" width="30" ></div>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>');

    });

    $('body').on('click', '.removeSkillBtn', function (e){
        e.preventDefault();
        $(this).closest('.skillsRow').remove();
    });


    $('.employeesFormBtn_wrapper').on('click', function (e) {
        e.preventDefault();
        $('#ClientInfoBtn').trigger('click');
    });


});
