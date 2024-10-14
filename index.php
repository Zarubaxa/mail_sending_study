<html>
<head>
    <meta charset="utf-8">
    <title>Отправка письма</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#btn_submit").click(function () {
                var user_name = $("#user_name").val().trim();
                var user_email = $("#user_email").val().trim();
                var user_phone = $("#user_phone").val().trim();
                var text_comment = $("#text_comment").val().trim();
                var re_em = /^[\w-\.]+@[\w-]+\.[a-z]{2,4}$/i;
                var ru_nu = /^[\d\+][\d\(\)\ -]{10,14}\d$/;
                var isValid = true;

                if (user_name == '') {
                    $('#user_name').addClass('error-border').removeClass('valid-border');
                    isValid = false;
                } else {
                    $('#user_name').addClass('valid-border').removeClass('error-border');
                }

                if (user_email == '' || !re_em.test(user_email)) {
                    $('#user_email').addClass('error-border').removeClass('valid-border');
                    isValid = false;
                } else {
                    $('#user_email').addClass('valid-border').removeClass('error-border');
                }

                if (user_phone == '' || !ru_nu.test(user_phone)) {
                    $('#user_phone').addClass('error-border').removeClass('valid-border');
                    isValid = false;
                } else {
                    $('#user_phone').addClass('valid-border').removeClass('error-border');
                }

                if (text_comment == '') {
                    $('#text_comment').addClass('error-border').removeClass('valid-border');
                    isValid = false;
                } else {
                    $('#text_comment').addClass('valid-border').removeClass('error-border');
                }

                if (isValid) {
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        dataType: "html",
                        data: {
                            "user_name": user_name,
                            "user_email": user_email,
                            "user_phone": user_phone,
                            "text_comment": text_comment
                        },
                        success: function (data) {
                            console.log(333);

                            $('.messages').html(data);
                            console.log(2222);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                            console.error('Ошибка: ', textStatus, errorThrown);
                            console.log(jqXHR.responseText); // Посмотреть полный ответ сервера
                        }
                    });
                }
            });
        });
    </script>
</head>

<body>
<div class="container">
    <div class="left">
        <div class="header">
            <h2 class="animation a1">Добро пожаловать!</h2>
            <h4 class="animation a2">Напишите письмо</h4>
        </div>
        <div class="form">
            <input type="text" class="form-field animation a1" id="user_name" placeholder="Ваше имя">
            <input type="text" class="form-field animation a2" id="user_email" placeholder="Ваш email">
            <input type="text" class="form-field animation a3" id="user_phone" placeholder="+78009999999">
            <textarea id="text_comment" class="form-field animation a4" placeholder="Напишите письмо"></textarea>
            <button class="animation a5" id="btn_submit">Отправить</button>
            <div class="messages"></div>
        </div>
    </div>
    <div class="right">
    </div>
</div>
</body>
</html>
