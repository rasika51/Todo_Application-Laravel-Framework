<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-image: url('https://www.w3schools.com/w3images/nature.jpg');
            background-size: cover;  /* Ensures the background image covers the entire viewport */
            background-position: center;  /* Centers the image */
            background-repeat: no-repeat;  /* Prevents the image from repeating */
            background-attachment: fixed;  /* Keeps the background fixed when scrolling */
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            width: 70%;
            border-radius: 15px;
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .form-control {
    border-radius: 10px; /* Default rounded corners */
    padding: 12px;
    width: 100%; /* Ensures the input takes 100% of the container width */
}

        .input-group input {
            border-radius: 10px;
            border: none;
            padding: 12px;
            margin-bottom: 10px;
            width: 100%;
        }

        .input-group button {
            border-radius: 10px;
            padding: 12px;
            font-size: 1.2rem;
        }

        .list-group-item {
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 10px;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .btn {
            border-radius: 10px;
            
        }

        .text-decoration-line-through {
            color: grey;
        }
        


     @media (min-width: 1024px) {
      .input-group button {
        width: 250px; /* Increase the button width for larger screens */
        padding: 15px 30px; /* Increase padding for a larger appearance */
        font-size: 1.4rem; /* Increase font size for better visibility */
        }
        .btn{
            width: 115px;
        }
        
    }

        /* Mobile and Tablet Responsiveness */
    @media (max-width: 768px) {
        h1 {
            font-size: 2rem;
        }

        .input-group {
            flex-direction: column;
        }

        .input-group input{
            width:100%;
        }

        input[type="text"] {
            font-size: 1rem;
        }

        button {
            font-size: 0.9rem;
        }

        ul.list-group li {
            flex-direction: column;
            align-items: flex-start;
        }

        ul.list-group li span {
            font-size: 1rem;
        }

        ul.list-group li .btn {
            font-size: 0.7rem;
        }
    }

 @media (max-width: 480px) {
    h1 {
        font-size: 1.5rem;
    }



    /* Adjust the input container (input group) */
    .input-group {
        display: flex;
        flex-direction: column; /* Stack input and button vertically */
        width: 100%; 
    }

    /* Input field styling */
    input[type="text"] {
        font-size: 1rem;
        width: 100%; /* Ensures the input takes full width */
        padding: 12px; /* Padding for a better touch target */
        box-sizing: border-box; /* Ensures padding doesn't affect width */
        margin-bottom: 10px; /* Space between input and button */
    }

    input[type="text"]::placeholder {
        font-size: 1rem; /* Matches input font size */
        width: 100%; 
        color: rgba(255, 255, 255, 0.7); /* Placeholder color */
    }


    button {
        font-size: 0.8rem;
        width: 100%;
    }

    ul.list-group li {
        padding: 10px;
        
    }

    ul.list-group li span {
        font-size: 0.9rem;
    }

    ul.list-group li .btn {
        font-size: 0.7rem;
        width: 100%;
        margin-top: 5px;
    }
    .form-control{
        width:100%;
    }


    </style>
    
    
    <script>
        // Check if success message exists and set timeout to hide it after 3 seconds
        window.onload = function() {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 1000); // 3000 milliseconds = 3 seconds
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
