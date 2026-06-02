<?php

use Livewire\Component;
use App\Models\Project;

new class extends Component
{
    public function getProjects()
    {
        return Project::latest()->get();
    }
};
?>

<div>
    {{-- main section --}}
    <section class="d-flex flex-column mx-auto" style="width: 500px; margin-top: 7em;">
        <div class="p-3 mb-3 rounded-3 d-flex justify-content-center" style="background-color: #344150;">
            <span class="fw-normal fs-6">Hello!, I'm a digital creator based in Indonesia</span>
        </div>
        
        <div class="d-flex flex-column gap-4 mt-4">
            <div class="d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex flex-column lh-1">
                    <span class="d-block fs-1 fw-bold">Geovan.</span>
                    <span class="fs-6 d-block fw-light">Graphic designer / Web developer</span>
                </div>
                <img src="{{ asset('assets/pic.jpg') }}" class="rounded-circle" style="width: 100px;" alt="">
            </div>
            
            <div class="d-flex flex-column gap-2">
                <h5 class="fs-5 fw-bold align-self-start bd-text">Info</h5>
                <div class="p-3 rounded-3" style="background-color: #4d4d5b30;">
                    <p class="fs-6 text-indent mb-0" style="text-align: justify">I am a Unversity Student that still learning about tech, especially in Web and Web App Development. I'm also doing some <a href="https://www.fiverr.com/s/DBpv72D" class="a-semi">freelance</a> work about Graphic Design especially in Shirt and Merch field. I have 4 years experience in Graphic Design field. Currently focusing in Web and App Development.</p>
                </div>
            </div>

            <div class="d-flex flex-column gap-2">
                <h5 class="fs-5 fw-bold align-self-start bd-text">Bio</h5>
                <div class="d-flex flex-row gap-5">
                    <span class="fs-6 fw-bold">2019</span>
                    <span class="fs-6">Japanese Language School 京進ランゲージアカデミー京都中央校, Kyoto</span>
                </div>
                <div class="d-flex flex-row gap-5">
                    <span class="fs-6 fw-bold">2021</span>
                    <span class="fs-6">Attend Graphic - Web Design Course at 日本コンピュータ専門学校 | 大阪, Osaka</span>
                </div>
                <div class="d-flex flex-row gap-0">
                    <span class="fs-6 fw-bold">2023 ~ Present</span>
                    <span class="fs-6">Currently Studying Information Technology at Satya Wacana Christian University</span>
                </div>
            </div>
            
            <div class="d-flex flex-column gap-2">    
                <h5 class="fs-5 fw-bold align-self-start bd-text">Favorite</h5>
                <div class="p-3 rounded-3" style="background-color: #4d4d5b30;">    
                    <p class="fs-6 text-indent text-indent mb-0"> I ♥︎  Music, <a href="http://instagram.com/rynnz.design" class="a-semi">Art</a>, Design, Coding, Japanese language, Anime, Thinkering my Thinkpad and 86 エイティシックス series :)</p>
                </div>
            </div>
            
            <div class="d-flex flex-column gap-3">    
                <h5 class="fs-5 fw-bold align-self-start bd-text">Reach me</h5>
                <div class="d-flex flex-row gap-2">
                    <i class="fa-brands fa-github fs-5"></i>
                    <a href="https://github.com/shinsix6" class="fs-6 a-link">@shinsix6</a>
                </div>
                <div class="d-flex flex-row gap-2">
                    <i class="fa-brands fa-square-instagram fs-5"></i>
                    <a href="https://www.instagram.com/_shooyuu" class="fs-6 a-link">@_shooyuu</a>
                </div>
                <div class="d-flex flex-row gap-2">
                    <i class="fa-solid fa-briefcase fs-5"></i>
                    <a href="https://www.fiverr.com/s/DBpv72D" class="fs-6 a-link">Fiverr</a>
                </div>
                </div>
                
                <div class="d-flex flex-column gap-3">
                    <h5 class="fs-5 fw-bold align-self-start bd-text">Latest work</h5>
                    <div class="row justify-content-between mx-0 w-100">   
                        @foreach ($this->getProjects()->take(2) as $project)
                            <div class="col-6 d-flex flex-column align-items-center text-center px-0" style="width: 47%;">
                                @if ($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" class="rounded-4 w-100" style="height: 140px; object-fit: cover;" alt="{{ $project->title }}">
                                @endif
                                <h5 class="card-title fw-bold text-center mt-2">
                                    {{ $project->title }}
                                </h5>
                                <p class="small w-100 text-center">
                                    {{ $project->description }}
                                </p>
                            </div> 
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>