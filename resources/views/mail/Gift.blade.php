

<!DOCTYPE html>
<html>
<head>
    <title>get your PLATEIT teckit </title>
    <style>
        body {
            background-color: #cbd7de;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        p{
            color: #747474;
        }
        h1{
            color:cadetblue;
        }
        .ticket-container {
            display: inline-block;
            /* padding: 20px; */
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            /* Set the dimensions of the div */
            width: 400px; /* Adjust as needed */
            height: 200px; /* Adjust as needed */
            /* Set background image and adjust background properties */
            background-image: url(images/medium_plate_vip.jpg);
            background-size: cover; /* Cover the entire div */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Do not repeat the background */
            position: relative;
        }

        .for {
            position: absolute;
            bottom: 0;
            left: 3%;
            color : #595a5c;
            font-size:x-small;

        }

        .start{
            text-align: start !important;
        }
        .ticket-image{
            max-width: 100%;
            max-height: 100%;
            width: 100%;
            height: 100%;
        }


        @media (max-width: 768px) {
            .ticket-container {
                width: 300px; /* Adjust width for smaller screens */
                height: 150px; /* Adjust height for smaller screens */
            }

            .fort {
                font-size: 6px; /* Adjust font size for smaller screens */
            }
        }

            @media (max-width: 480px) {
                .ticket-container {
                    width: 200px; /* Adjust width for even smaller screens */
                    height: 100px; /* Adjust height for even smaller screens */
                }

                .for {
                    font-size: 6px !important; /* Adjust font size for even smaller screens */
                }
            }

    </style>
</head>
<body>
<h1>Congratulations on Your Ticket Purchase!</h1>
        <p class="start">

            {{-- Dear {{$data['name']}},<br><br> --}}

            We are thrilled to inform you that your recent ticket purchase has been successfully processed. You have used your accumulated points wisely, and we're excited to see you at the event/experience.<br>

            Your ticket details are as follows:<br><br>

            Name: {{$data['name']}}<br>
            E-mail: {{$data['email']}}<br>
            Ticket ID: {{$data['Ticket_id']}}<br>
            Date: {{$data['date']}}<br><br>


</p>

    <div class="ticket-container">
        <img class="ticket-image" src="{{ $message->embed(public_path('images/gifts/email_gifts/'.$data['Ticket'])) }}" alt="Embedded Image">

        <!-- <img class="ticket-image" src="images/large_plate_vip.png" alt="Embedded Image"> -->

       <p class="for">
        FOR : {{$data['name']}}
       </p>
    </div>
    <p class="start">
    We hope you have an incredible time and enjoy every moment of the event/experience. Thank you for being a valued member of our community and for choosing to use your points with us.<br>

    If you have any questions or need further assistance, please feel free to contact us.<br><br>

    Best regards,
    PLATEIT Team<br>

    </p>
</body>
</html>
