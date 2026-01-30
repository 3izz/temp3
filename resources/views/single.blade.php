 
@include('navbar')  
<link rel="stylesheet" href="{{asset('single.css')}}">
 
<header>
    <div class="header-logo">
     <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/150' }}" alt="{{ $course->title }}">


    </div>
    <div class="header-text">
        <h2>{{ $course->title }}</h2>
        <h1>{{ $course->language }} - {{ $course->level }}<br>{{ $course->duration ?? 'N/A' }}</h1>
    </div>
</header>

<div class="container">

    <div class="top-section">

        <div class="left-col">
            <h3 class="section-title">About The Course</h3>
            <p class="description">
                {{ $course->description ?? 'No description available for this course.' }}
            </p>

            <h3 class="section-title">Objectives</h3>
            <ul class="objectives-list">
                @if($course->objectives)
    @foreach(explode(',', $course->objectives) as $objective)
        <li><i class="far fa-check-circle"></i> {{ trim($objective) }}</li>
    @endforeach
@else
    <li><i class="far fa-check-circle"></i> No objectives added yet.</li>
@endif

            </ul>
        </div>

        <div class="right-col">
            <h3 class="section-title">Course Content</h3>

          <div class="curriculum-card"> 
    <ul class="curriculum-list">
        @if($course->content)
            @foreach(explode(',', $course->content) as $index => $item)
                <li>
                    <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }} {{ trim($item) }}</span>
                    <i class="fas fa-chevron-down"></i>
                </li>
            @endforeach
        @else
            <li>No content added yet.</li>
        @endif
    </ul>
</div>


                </ul>
            </div>

            <div class="dots-decoration">
                ....<br>....<br>....<br>....
            </div>
             
    </div>

    <div class="section-heading-row">
        <h3>Projects</h3>
        <div class="line"></div>
    </div>

    <div class="projects-grid">
    @if($course->projects)
        @foreach(explode(',', $course->projects) as $project)
            <div class="project-card">
                <div class="project-icon"><i class="fas fa-shield-alt"></i></div>
                <div>
                    <div class="project-title">{{ trim($project) }}</div>
                </div>
            </div>
        @endforeach
    @else
        <div class="project-card">No projects added yet.</div>
    @endif
</div>


    <div class="cta-box">
        <div class="cta-text">
            <h2>Wanna check more<br>about the course?</h2>
        </div>
        <div class="cta-buttons">
            <div class="btn-row">
                <a href="#" class="btn btn-outline"><i class="fas fa-desktop"></i> Demo</a>
                <a href="#" class="btn btn-outline"><i class="fas fa-bookmark"></i> Enroll Now</a>
            </div>
            <a href="#" class="btn btn-solid"><i class="fas fa-cloud-download-alt"></i> Download Curriculum</a>
        </div>
    </div>

   

        <div class="tools-section">
            <div class="section-heading-row">
                <h3>Tools & Platforms</h3>
                <div class="line"></div>
            </div>
            
            <div class="tools-icons">
                <div class="tool-circle">UI</div>
                <div class="tool-circle"><svg width="216" height="216" viewBox="0 0 216 216" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="108" cy="108" r="108" fill="#003F7D"/>
</svg>
</div>
                <div class="tool-circle"><i class="fas fa-infinity"></i></div>
                <div class="tool-circle">UI</div>
                <div class="tool-circle"><i class="fab fa-react"></i></div>
                <div class="tool-circle"><i class="fab fa-cutil"></i></div>
            </div>
        </div>
    </div>

</div>
@include('footer')
 