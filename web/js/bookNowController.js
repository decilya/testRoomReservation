"use strict";

function BookNowController() {
    let myObj = this;

    this.init = function () {
        myObj.bookNowClick();
    };

    this.bookNowClick = function () {
        $('.bookNow').on('click', function () {
            let roomId = $(this).attr('data-room');
            let phone = $('#phone' + roomId).val();
            let userName = $('#user_name' + roomId).val();
            let day = $('#day' + roomId).val();
            let dayCalc = $('#day_calc' + roomId).val();

            $.ajax({
                method: "POST",
                url: "/site/book-now",
                data: {
                    roomId: roomId,
                    phone: phone,
                    userName: userName,
                    day: day,
                    dayCalc: dayCalc
                },
                dataType: 'json',
                success: function success(data) {

                    if (data === true) {
                        bootbox.alert("Вы успешно забронировали номер");
                    } else if (data === false) {
                        bootbox.alert("Номер занят на эти даты");
                    } else {
                        console.log(data);
                    }

                    console.log(data);
                },
                error: function error() {
                    bootbox.alert("При бронировании произошла заказа");
                }
            });
        });
    };
}

/** ready */
$(function () {
    let myBookNowController = new BookNowController();
    myBookNowController.init();
});