<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            overflow: hidden;
        }

        img {
            margin-top: 3rem;
            margin-bottom: 3rem;
            width: 300px;
        }

        input:focus {
            outline: none !important;
            border: 2px solid #0d9cfa;
        }

        h5 {
            font-weight: 600;
            margin: 15px;
            color: rgb(94, 108, 132);
            font-size: 1em;
            line-height: 1.1428571428571428;
            letter-spacing: -.003em;
            text-align: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        }

        p {
            font-size: 2.4rem;
            margin-top: 0.30rem;
            margin-bottom: 0.89rem;
        }

        input {
            font-size: 14px;
            border: 2px solid grey;
            line-height: 35px;
            border-radius: 5px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background-color: #fafbfc;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 400px;
            border-radius: 5px;
            background-color: white;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 1rem 3rem;
            display: flex;
            flex-direction: column;
        }

        button {
            margin-top: 1rem;
            align-self: center;
            width: 100%;
            border-radius: 5px;
            background-color: grey;
            border: none;
            padding: 10px 22px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            font-size: 1rem;
            color: white;
            cursor: pointer;
        }

        @media only screen and (max-width: 500px) {
            .card {
                width: 340px;
            }
        }

        ::-webkit-input-placeholder {
            text-align: center;
        }

        :-moz-placeholder {
            /* Firefox 18- */
            text-align: center;
        }

        ::-moz-placeholder {
            /* Firefox 19+ */
            text-align: center;
        }

        :-ms-input-placeholder {
            text-align: center;
        }

        .loader {
            margin-top: 1rem;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 50px;
            height: 50px;
            align-self: center;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="content">
        <img src="{{ asset('favicon.png') }}" alt="logo-rendiapps" style="outline:none;width:9%;text-decoration:none;max-width:100%;font-size:16px" width="229" align="middle" class="CToWUd a6T" tabindex="0">
        <div class="card">
            <div class="container">
                <form action="">
                    <h5 id="h51"> Elige una nueva contraseña</h5>
                    <input id="token" size="50" style="display: none;" type="text" value="{{$token}}">
                    <input id="pwd" onkeyup="validateForm()" placeholder="Utiliza palabras que sean fáciles de recordar" id="email" type="password">
                    <h5 id="h52"> Confirma tu contraseña</h5>
                    <input onkeyup="validateForm()" id="pwdconfirm" type="password">
                    <hr style="width: 100%; margin-top: 1.4rem;">
                    <button disabled="true" type="submit">Continuar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const formTag = document.querySelector('form');
        const h51Tag = document.getElementById('h51');
        const h52Tag = document.getElementById('h52');

        var pwd = document.getElementById("pwd");
        var pwdconfirm = document.getElementById("pwdconfirm");
        var btn = formTag.elements[3];
        const containerTag = document.querySelector('.container');
        const token = formTag.elements[0].value;
        const loader = document.createElement('div');

        function validateForm() {
            if (pwd.value.length > 0 && pwdconfirm.value.length > 0) {
                btn.disabled = false;
                btn.style.backgroundColor = "#0CAD78";
            } else {
                btn.disabled = true;
                btn.style.backgroundColor = "grey";
            }
        }

        document.addEventListener('submit', async function(event) {
            event.preventDefault();
            if (pwd.value != pwdconfirm.value) {
                Swal.fire({
                    width: 419,
                    icon: 'error',
                    title: 'Las contraseñas no coinciden',
                    showConfirmButton: false,
                    timer: 1500
                })
                return;
            }

            if (pwd.value.length < 6) {
                Swal.fire({
                    width: 410,
                    icon: 'error',
                    title: 'La contraseña debe contar con un mínimo de 6 caracteres',
                    showConfirmButton: false,
                    timer: 1500
                })
                return;
            }

            containerTag.appendChild(loader);
            loader.classList.add('loader');

            btn.disabled = true;
            btn.style.backgroundColor = "grey";

            const json = {
                pwdToken: token,
                password: pwd.value
            }

            const response = await fetch('<?php echo env('API_URL'); ?>/recoverPassword/reset', {
                method: 'POST',
                mode: 'cors',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(json)
            }).then(function(response) {
                return response.json()
            }).then(function(data) {
                console.log(data);
                containerTag.removeChild(loader);
                btn.disabled = false;
                btn.style.backgroundColor = "#0CAD78";
                if (!data.error) {
                    Swal.fire({
                        width: 410,
                        icon: 'success',
                        title: 'Contraseña restablecida con éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    h51Tag.style.margin = "0"
                    h51Tag.innerHTML = "Se ha cambiado con éxito la contraseña de tu cuenta de RendiApps<br><br>Puedes iniciar sesión desde la aplicación web<br> "

                    formTag.removeChild(h52Tag)
                    formTag.removeChild(pwd);
                    formTag.removeChild(pwdconfirm);
                    formTag.removeChild(btn);
                } else {
                    Swal.fire({
                        width: 410,
                        icon: 'error',
                        title: 'No es posible restablecer su contraseña en este momento',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return;
                }
            })
        })
    </script>

</body>

</html>