<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certification de Félicitation</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {

            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .download-btn {
            z-index: 111111;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            background-color: #d4af37;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
        }

        .certificate {
            background: white;
            border: 15px solid transparent;
            padding: 30px;
            box-sizing: border-box;
            position: relative;
            height: 700px;
            margin: auto;

            border: 10px solid #d4af37;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            font-family: 'Times New Roman', serif;
        }

        .certificate::before {
            content: "";
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, #d4af37, #f3e5ab, #d4af37);
            z-index: -1;
            border-radius: 10px;
        }

        .certificate::after {
            content: "";
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 10px solid #d4af37;
            z-index: -1;
            border-radius: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .logo {
            text-align: center;
            margin: 0.5rem -2rem;
            width: 20%;
        }

        .logo img {
            width: 80px;
        }

        .title {
            text-align: center;
            margin: -7px 13.6745em 0 0;
        }

        h1 {
            margin: -10px 0 10px 0;
            color: #1b70b4;
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 30pt;

        }

        .title h2,
        .title h3,
        .title h4 {
            line-height: 0.2;
            font-family: 'Times New Roman', Times, serif !important;
            /* Ajustez cette valeur selon le besoin */
        }

        .content {
            font-size: 12pt;
            color: #333;
            margin: 20px 40px;
            width: 90%;
            line-height: 1.5;
            font-family: 'Times New Roman', Times, serif;
        }

        .signature {
            position: absolute;
            top: 475px;
            left: 50px;
            right: 50px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .signature div {
            width: 45%;
            text-align: center;
            border-top: 2px solid #333;
            padding-top: 1px;
        }

        .person-name {
            font-family: 'Dancing Script', fantasy;
            /* Application de la police manuscrite */
            font-size: 26pt;
            font-weight: bold;
            margin: 10px;
        }
    </style>
</head>

<body>
    <button class="download-btn" id="downloadPDF">Télécharger</button>

    <div class="certificate" id="printCertificat">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('assets/images/Lutherrose.png') }}" alt="Logo">
                <p>Jesosy irery ihany</p>
            </div>
            <div class="title">
                <h2>FIANGONANA LOTERANA MALAGASY (FLM)</h2>
                <h3>SYNODAM-PARITANY MENAGNARA</h3>
                <h3>FILEOVANA AMBOHIJATOVO</h3>
                <h4>FIANGONANA AMBOHITAJOTO, VANGAINDRANO</h4>
            </div>
        </div>

        <h1>MARIM-PANKASITRAHANA</h1>
        <p class="content">
            Ny Fitandremana Ambohijatovo dia maneho ny fisaorana sy fankasitrahana anareo <br>
            <i class="person-name">{{ ucfirst(strtolower($personne)) }}</i>
            <br>
            noho ny fandraisanareo anjara tamin'ny ezaka ho fanatsarana ny tranon 'Andriamanitra.
        </p>

        <div class="signature">
            <div>
                <p>Ny Kaomity</p>
            </div>
            <div>
                <p>Ny Pasotora</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("downloadPDF").addEventListener("click", function() {
            const element = document.getElementById("printCertificat");
            const options = {
                margin: 10,
                filename: 'certificat.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'landscape'
                }
            };

            html2pdf().set(options).from(element).save();
        });
    </script>
</body>

</html>
