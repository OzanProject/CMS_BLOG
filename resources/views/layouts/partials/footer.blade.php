<!-- Footer Start -->
<div class="container-fluid pt-4 px-4 mt-auto">
    <div class="bg-secondary rounded-top p-4">
        <div class="col-12 text-center">
            <p class="mb-0">
                &copy; {{ date('Y') }} <a href="#"
                    class="text-decoration-none text-primary">{{ $settings['site_name'] ?? config('app.name') }}</a>.
                All Rights Reserved.
                <br>
                {{ $settings['footer_text'] ?? '' }}
            </p>
        </div>
    </div>
</div>
<!-- Footer End -->

<style>
    /* Responsif footer untuk perangkat kecil */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    /* Gaya link footer */
    .text-primary {
        color: #007bff !important;
    }

    .text-primary:hover {
        color: #0056b3 !important;
    }

    /* Tambahan padding bawah */
    .bg-secondary {
        padding-bottom: 10px;
    }
</style>