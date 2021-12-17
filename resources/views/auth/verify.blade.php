<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('public') }}/assets/css/app.css">
    <style>
        body {
            background: #eee;
        }

        .bgWhite {
            background: white;
            box-shadow: 0px 3px 6px 0px #cacaca;
        }

        .title {
            font-weight: 600;
            margin-top: 20px;
            font-size: 24px
        }

        .customBtn {
            border-radius: 0px;
            padding: 10px;
        }

        form input {
            display: inline-block;
            width: 50px;
            height: 50px;
            text-align: center;
        }

    </style>
</head>

<body>
    <div id="app">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-4 text-center">
                    <div class="row">
                        <div class="col-sm-12 mt-5 bgWhite">
                            <div class="title">
                                Verify OTP
                            </div>

                            <form action="" class="mt-5">
                                <input class="otp" type="text" oninput='digitValidate(this)'
                                    onkeyup='tabChange(1)' maxlength=1>
                                <input class="otp" type="text" oninput='digitValidate(this)'
                                    onkeyup='tabChange(2)' maxlength=1>
                                <input class="otp" type="text" oninput='digitValidate(this)'
                                    onkeyup='tabChange(3)' maxlength=1>
                                <input class="otp" type="text" oninput='digitValidate(this)'
                                    onkeyup='tabChange(4)' maxlength=1>
                            </form>
                            <hr class="mt-4">
                            <button v-on:click="verify()" class='btn btn-primary btn-block mt-4 mb-4 customBtn'>Verify</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- development version, includes helpful console warnings -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue!'
            },
            methods: {
                verify: function() {
                    let otp = [];
                    let element = document.querySelectorAll('input');
                    
                    for(e in element) {
                        otp.push(element[e].value);
                     }
                  /*   if (ele[val - 1].value != '') {
                        ele[val].focus()
                    } else if (ele[val - 1].value == '') {
                        ele[val - 2].focus()
                    } */

                 
                    fetch('{{ route('admin.verify') }}', {
                            method: 'post',
                            headers: {
                                "Content-type": "application/json",
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                 'otp': otp.join("") 
                            })
                        })
                        .then(response => response.json())
                        .then(function(data) {
                            if(data.success) {
                                window.location.reload();
                            }
                             console.log( data);
                        })
                        .catch(function(error) {
                           // console.log('{{ json_encode(session('user')) }}');
                            console.log('Request failed', error);
                        });
                },
                reverseMessage: function() {
                    this.message = this.message.split('').reverse().join('')
                }
            },
            mounted() {
                /*    axios
                                    .get('https://api.coindesk.com/v1/bpi/currentprice.json')
                                    .then(response => (this.info = response))
                 */
               // this.verify();
                fetch('https://anydoctor.org/api/doctor/department').then(
                        function(response) {
                            if (response.status !== 200) {
                                console.log('Looks like there was a problem. Status Code: ' +
                                    response.status);
                                return;
                            }

                            // Examine the text in the response
                            response.json().then(function(data) {
                                console.log(data);
                            });
                        }
                    )
                    .catch(function(err) {
                        console.log('Fetch Error :-S', err);
                    });
            }
        })
    </script>
    <script>
        let digitValidate = function(ele) {
            console.log(ele.value);
            ele.value = ele.value.replace(/[^0-9]/g, '');
        }

        let tabChange = function(val) {
            let ele = document.querySelectorAll('input');
            if (ele[val - 1].value != '') {
                ele[val].focus()
            } else if (ele[val - 1].value == '') {
                ele[val - 2].focus()
            }
        }
    </script>
</body>

</html>
