<div class="swiper-slide h-auto pb-3">
    <article class="card h-100 border-0 shadow-sm mx-2">
        <div class="position-relative">
            <a href="{{ route('front.detailsCourse') }}" class="d-block position-absolute w-100 h-100 top-0 start-0" aria-label="Course link"></a>
                <span class="badge bg-success position-absolute top-0 start-0 zindex-2 mt-3 ms-3">Best Seller</span>
                <a href="#" class="btn btn-icon btn-light bg-white border-white btn-sm rounded-circle position-absolute top-0 end-0 zindex-2 me-3 mt-3" data-bs-toggle="tooltip" data-bs-placement="left" title="Guardar a favorito" aria-label="Guardar a favorito">
                    <i class="bx bx-bookmark"></i>
                </a>
            <img src="{{ asset('front/img/cursos/'.$dataObject['thumbnail']) }}" class="card-img-top" alt="Image">
        </div>
        <div class="card-body pb-3">
            <h3 class="h5 mb-2">
                <a href="/">{{$dataObject['title']}}</a>
            </h3>
            <p class="fs-sm mb-2">
                {{$dataObject['description']}}
            </p>
            <p class="fs-sm mb-2">By {{ $dataObject['teacher'] }}</p>
            <p class="fs-lg fw-semibold text-primary mb-0">Gs. {{ $dataObject['price'] }}</p>
        </div>
        <div class="card-footer d-flex align-items-center fs-sm text-muted py-4 justify-content-between">
            <div class="d-flex align-items-center">
                <i class="bx bx-time fs-xl me-1"></i>
                220 Hs.
            </div>
            <div class="d-flex align-items-center">
                <i class='bx bxs-invader fs-xl me-1'></i>
                Básico
            </div>
            <div class="d-flex align-items-center">
                <i class='bx bxs-extension fs-xl me-1'></i>
                5 Lecciones
            </div>
        </div>
    </article>
</div>