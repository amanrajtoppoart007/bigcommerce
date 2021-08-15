<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=" theme-color" content="#fff">
    <meta name="description" content="Website Description">

    <!-- Botstrap 4.5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Google Fonts Nunito -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Title -->
    <title>KV Pro - Kisan Card</title>

    <style type="text/css">
        div.kisan-card {
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            height: auto;
            width: 700px;
        }
        div.card-header {
            background-color: #ff5714;
        }
        div.card-footer {
            background-color: #70e000;
        }
        div.kisan-card * {
            font-family: 'Poppins', sans-serif;
        }
        *.text-green {
            color: #007200;
        }
        *.text-dark-green {
            color: #004b23;
        }
        p.reg-no {
            font-size: 0.9rem;
        }
    </style>


</head>

<body>

<!-- Main (Start) -->
<main>


    <div class="container">
        <br>
        <br>

        <!-- Kisan Card (Start) -->
        <div class="card kisan-card">
            <div class="card-header pb-1">
                <p class="text-white mb-1 float-right reg-no">Reg. No. {{ $user->registration_number ?? '' }}</p>
                <h3 class="font-weight-bold text-white">Kisan Card</h3>

            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-4">
                        <div class="card-body">
                            <img src="https://image.freepik.com/free-photo/portrait-farmer-with-apron_23-2148579683.jpg" class="img-fluid img-thumbnail shadow border-success bg-success">
                        </div>

                    </div>
                    <div class="col-8">
                        <div class="card-body px-0">
                            <h4 class="text-dark-green mt-2 font-weight-bolder">Name : <span class="text-green"> {{ $kisanCard->name ?? '' }}</span></h4>
                            <h6 class="text-dark-green mt-3 font-weight-bolder">Registration Date : <span class="text-green">{{ isset($kisanCard->registration_date) ? date('d-m-Y', strtotime($kisanCard->registration_date)) : ''  }}</span></h6>
                            <h6 class="text-dark-green mt-3 font-weight-bolder">Expiry Date : <span class="text-green">{{ isset($kisanCard->expiry_date) ? date('d-m-Y', strtotime($kisanCard->expiry_date)) : ''  }}</span></h6>
                            <h6 class="text-dark-green mt-3 font-weight-bolder">Address : <span class="text-green">{{ $addressString }}</span></h6>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="#" class="text-dark-green font-weight-bolder card-link float-left">Website : krishakvikas.com</a>
                <a href="tel: 1234567890" class="text-dark-green font-weight-bolder card-link float-right">Kisan Help No. 1234567890</a>
            </div>
        </div>
        <!-- Kisan Card (End) -->
        <button class="btn btn-danger mt-5" onclick="printCard()">Print</button>

    </div>
</main>
<!-- Main (End) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<script>
    function printCard()
    {
        let printableAreaObj = $('.kisan-card');
        $('body').html(printableAreaObj.html());

        window.print();
        location.reload();
    }
</script>
</body>
</html>
