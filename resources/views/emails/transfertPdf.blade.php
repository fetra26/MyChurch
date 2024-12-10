<!DOCTYPE html>
<html>
<head>
    <title>Fangatahana Hifindra Fiangonana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            height: 60px;
        }
        .content {
            line-height: 1.8;
        }
        .signature {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        {{-- <img src="{{ asset('path/to/logo.png') }}" alt="Church Logo"> --}}
        <h3>FEDERASIONA {{ $data['federation'] ?? '.................................' }}</h3>
        <h4>Fiangonana ao {{ $data['church_name'] ?? '.................................' }}</h4>
        <h4>Taratasy fangatahana hifindra fiangonana</h4>
    </div>

    <div class="content">
        <p>
            Date: {{ $data['date'] ?? '__/__/____' }}
        </p>

        <p>
            Ho an’ny MpitantSoratra ny fiangonana Adventista mitandrina ny andro fahafito ao
            {{ $data['church_address'] ?? '.................................' }}
        </p>

        <p>
            Ny rahalahy/ny rahavavy: <br>
            Ny anadahiny/ny anabaviny:
        </p>   
        <p>
            {{ $data['applicant_name'] ?? '.................................' }}izay mbola voasoratra ato amin\'ny rejistry ny fiangonanareo ny anarany dia naneho tamin\'ny faniriany Mba hifindra aty amin\'ny fiangonana aty:<br>
        </p>

        <p>
            {{ $data['destination'] ?? '.................................' }}
        </p>

        <p>
            Noho izany, miangavy anareo izahay mba handefa avy hatrany ny taratasy fangataham-pifindrana amin’ny
            anaran’ity rahalahy/rahavavy-anadahiny/anabaviny ity raha vao nisy ny fanapahan-kevitrareo mankatoa izany.
        </p>
    </div>

    <div class="signature">
        <p>Raiso tompoko ny firariantsoa ombam-pirahalahiana atolotray</p>
        <p>Anaran'ny Mpitantsoratra: {{ $data['secretary_name'] ?? '.................................' }}</p>
        <p>Sonia: ...........................................................</p>

        <p>Anaran’ny Pasitora/Loholon’ny Fiangonana: {{ $data['pastor_name'] ?? '.................................' }}</p>
        <p>Sonia: ...........................................................</p>
    </div>
</body>
</html>
