@include('navbar')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Match courses index pagination / utility styles */
    .pagination { display: flex; gap: 10px; list-style: none; padding: 0; margin: 0; flex-wrap: wrap; justify-content: center; }
    .pagination .page-item { display: flex; }
    .pagination .page-link {
        min-width: 42px;
        height: 42px;
        padding: 0 14px;
        border-radius: 9999px;
        border: 1px solid #ffccb3;
        background: #fff;
        color: #555;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        font-weight: 600;
        transition: 0.2s;
    }
    .pagination .page-link:hover { background: #fff7f2; border-color: #ff8c55; color: #0f2942; }
    .pagination .page-item.active .page-link { background: #ff8c55; border-color: #ff8c55; color: #fff; }
    .pagination .page-item.disabled .page-link { opacity: 0.55; cursor: not-allowed; }

    /* Course card - same as courses index, plus selection and lock states */
    .course-selector-card {
        background-color: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        transition: transform 0.2s;
        position: relative;
        pointer-events: auto;
        user-select: text;
    }
    .course-selector-card.selected {
        box-shadow: 0 10px 25px rgba(255, 140, 85, 0.25);
        border: 2px solid #ff8c55;
    }
    .course-selector-card.locked {
        opacity: 0.75;
        pointer-events: none;
    }
    .course-selector-card.locked .card-lock-overlay {
        display: flex;
    }
    .card-lock-overlay {
        display: none;
        position: absolute;
        inset: 0;
        background: rgba(15, 41, 66, 0.6);
        border-radius: 20px;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }
    .card-lock-overlay i {
        font-size: 3rem;
        color: #fff;
    }
    .course-selector-card .card-top {
        background-color: #0a3d62;
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .course-selector-card .card-body {
        padding: 20px 20px 25px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .course-selector-card .card-title {
        font-size: 1.2rem;
        margin: 0 0 10px 0;
        color: #333;
        font-weight: 600;
        user-select: text;
        pointer-events: auto;
    }
    .course-selector-card .card-desc {
        font-size: 0.8rem;
        color: #777;
        line-height: 1.5;
        margin-bottom: 10px;
        flex-grow: 1;
        user-select: text;
        pointer-events: auto;
    }
    .course-selector-card .card-instructor {
        font-size: 0.75rem;
        color: #aaa;
        margin-bottom: 20px;
        user-select: text;
        pointer-events: auto;
    }
    .course-selector-card.unlocked {
        cursor: pointer;
    }
    .course-selector-card.unlocked:hover {
        transform: translateY(-2px);
    }
    .course-selector-card .select-indicator {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #ff8c55;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        transition: background 0.2s, color 0.2s;
    }
    .course-selector-card.selected .select-indicator {
        background: #ff8c55;
        color: #fff;
    }
    .course-selector-card .select-indicator i {
        font-size: 0.75rem;
    }

    .select-courses-submit {
        margin-top: 40px;
        padding: 30px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        text-align: center;
    }
    .select-courses-submit .selection-count {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 20px;
    }
    .select-courses-submit .selection-count.valid {
        color: #0f2942;
        font-weight: 600;
    }
    .select-courses-submit .selection-count.invalid {
        color: #777;
    }
    .select-courses-submit .btn-proceed {
        background-color: #ff8c55;
        color: white;
        padding: 14px 32px;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(255, 140, 85, 0.3);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: transform 0.2s, opacity 0.2s;
    }
    .select-courses-submit .btn-proceed:hover:not(:disabled) {
        transform: translateY(-2px);
    }
    .select-courses-submit .btn-proceed:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .select-courses-submit .back-link {
        display: inline-block;
        margin-top: 15px;
        color: #555;
        font-size: 0.9rem;
        text-decoration: none;
    }
    .select-courses-submit .back-link:hover {
        color: #ff8c55;
    }
    .error-message {
        max-width: 900px;
        margin: 0 auto 20px auto;
        background: #fff5f5;
        border: 1px solid #feb2b2;
        color: #c53030;
        padding: 12px 16px;
        border-radius: 10px;
        text-align: center;
    }

    @media (max-width: 480px) {
        .pagination { gap: 8px; }
        .pagination .page-link { min-width: 38px; height: 38px; padding: 0 12px; font-size: 0.9rem; }
    }
</style>

<div style="font-family: 'Poppins', sans-serif; background-color: #f4f6f9; min-height: 100vh; padding: 40px 20px; position: relative; z-index: 1;">

    <div class="container" style="max-width: 1400px; margin: 0 auto;">

        <header class="page-header" style="text-align: center; margin-bottom: 30px; padding: 10px 0;">
            <h1 style="font-size: 2.5rem; color: #0f2942; font-weight: 700; margin: 0;">
                Select <span style="color: #ff8c55;">Courses</span>
            </h1>
            <p style="color: #777; margin-top: 8px;">Package: <strong>{{ $package->name }}</strong> — Choose up to <strong>{{ $maxSelectable }}</strong> course(s) included in your plan.</p>

            @if (session('info'))
                <div style="max-width: 900px; margin: 0 auto 20px auto; background: #fff7f2; border: 1px solid #ffccb3; color: #0f2942; padding: 12px 16px; border-radius: 10px; text-align: center;">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    <ul style="margin: 0; padding-left: 20px; text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="controls-bar" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 40px; gap: 20px; background-color: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                <div style="background-color: #eef1f6; padding: 10px 20px; border-radius: 5px; display: flex; align-items: center; width: 300px;">
                    <i class="fa-solid fa-magnifying-glass" style="color:#777;"></i>
                    <input type="text" id="course-search" placeholder="Search courses..." value=""
                           style="border:none; background:transparent; outline:none; margin-left:10px; width:100%; font-size:0.95rem; pointer-events: auto; user-select: text; z-index: 10; position: relative;">
                </div>
                <div class="tabs" style="display: flex; gap: 30px; font-weight: 500; color: #777;">
                    <span style="color: #ff8c55; border-bottom: 3px solid #ff8c55; padding-bottom: 5px;">All</span>
                </div>
                <div class="sort-box" style="color: #555; font-size: 0.9rem;">
                    Select up to <strong>{{ $maxSelectable }}</strong> course(s)
                </div>
            </div>
        </header>

        <form method="POST" action="{{ route('pricing.subscribe', $package->id) }}" id="select-courses-form">
            @csrf

            <div class="courses-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
                @foreach ($courses as $course)
                    @php
                        $isUnlocked = in_array($course->id, $unlockedCourseIds, true);
                    @endphp
                    <div class="course-selector-card {{ $isUnlocked ? 'unlocked' : 'locked' }}"
                         data-course-id="{{ $course->id }}"
                         data-unlocked="{{ $isUnlocked ? '1' : '0' }}"
                         data-title="{{ strtolower($course->title) }}"
                         data-description="{{ strtolower($course->description ?? '') }}">
                        @if (!$isUnlocked)
                            <div class="card-lock-overlay">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                        @endif
                        @if ($isUnlocked)
                            <div class="select-indicator"><i class="fa-solid fa-check"></i></div>
                            <input type="checkbox"
                                   name="selected_courses[]"
                                   value="{{ $course->id }}"
                                   id="course-checkbox-{{ $course->id }}"
                                   class="course-checkbox"
                                   style="position: absolute; opacity: 0; pointer-events: none;">
                        @endif

                        <div class="card-top">
                            <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/150' }}"
                                 alt="{{ $course->title }}"
                                 style="width: 80px; height: 80px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255,255,255,0.2));">
                        </div>

                        <div class="card-body">
                            <h3 class="card-title">{{ $course->title }}</h3>
                            <p class="card-desc">
                                {{ Str::limit($course->description ?? 'No description available.', 80) }}
                            </p>
                            <p class="card-instructor">
                                <i class="fa-solid fa-user-tie"></i> {{ $course->instructor->name ?? 'Instructor' }}
                            </p>
                            @if ($isUnlocked)
                                <span style="font-size: 0.75rem; color: #ff8c55;"><i class="fa-solid fa-circle-check"></i> Included in your plan — click to select</span>
                            @else
                                <span style="font-size: 0.75rem; color: #999;"><i class="fa-solid fa-lock"></i> Not in this plan</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($courses->isEmpty())
                <div style="grid-column: 1 / -1; text-align: center; color: #777; padding: 50px;">
                    <h3>No courses found.</h3>
                </div>
            @endif

            <div class="select-courses-submit">
                <div class="selection-count invalid" id="selection-count">
                    Please select <strong>{{ $maxSelectable }}</strong> course(s) to proceed.
                </div>
                <button type="submit" class="btn-proceed" id="submit-btn" disabled>
                    <i class="fa-solid fa-credit-card"></i> Proceed to Checkout
                </button>
                <div>
                    <a href="{{ route('pricing.index') }}" class="back-link">
                        <i class="fa-solid fa-arrow-left"></i> Back to Packages
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@include('footer')

<script>
(function () {
    const maxSelectable = {{ $maxSelectable }};
    const form = document.getElementById('select-courses-form');
    const submitBtn = document.getElementById('submit-btn');
    const selectionCountEl = document.getElementById('selection-count');
    const searchInput = document.getElementById('course-search');

    function getUnlockedCards() {
        return document.querySelectorAll('.course-selector-card.unlocked');
    }

    function getSelectedCheckboxes() {
        return document.querySelectorAll('.course-checkbox:checked');
    }

    function updateSelectionUI() {
        const selected = getSelectedCheckboxes();
        const count = selected.length;

        document.querySelectorAll('.course-selector-card.unlocked').forEach(function (card) {
            const cb = card.querySelector('.course-checkbox');
            card.classList.toggle('selected', cb && cb.checked);
        });

        if (count === maxSelectable) {
            selectionCountEl.innerHTML = '&check; <strong>' + count + '</strong> course(s) selected — Ready to proceed!';
            selectionCountEl.className = 'selection-count valid';
            submitBtn.disabled = false;
        } else if (count > maxSelectable) {
            selectionCountEl.innerHTML = 'Too many selected. Maximum: <strong>' + maxSelectable + '</strong>. Deselect ' + (count - maxSelectable) + ' course(s).';
            selectionCountEl.className = 'selection-count invalid';
            submitBtn.disabled = true;
        } else {
            selectionCountEl.innerHTML = 'Please select <strong>' + (maxSelectable - count) + '</strong> more course(s) to proceed.';
            selectionCountEl.className = 'selection-count invalid';
            submitBtn.disabled = true;
        }
    }

    document.querySelectorAll('.course-selector-card.unlocked').forEach(function (card) {
        card.addEventListener('click', function (e) {
            const checkbox = card.querySelector('.course-checkbox');
            if (!checkbox) return;
            const selected = getSelectedCheckboxes().length;
            if (checkbox.checked) {
                checkbox.checked = false;
            } else {
                if (selected >= maxSelectable) {
                    return;
                }
                checkbox.checked = true;
            }
            updateSelectionUI();
        });
    });

    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('course-checkbox')) return;
        const selected = getSelectedCheckboxes();
        if (selected.length > maxSelectable) {
            e.target.checked = false;
            updateSelectionUI();
        }
    });

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            document.querySelectorAll('.course-selector-card').forEach(function (card) {
                const title = (card.getAttribute('data-title') || '');
                const desc = (card.getAttribute('data-description') || '');
                const show = !q || title.includes(q) || desc.includes(q);
                card.style.display = show ? '' : 'none';
            });
        });
    }

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.textContent = ' Redirecting… ';
    });

    updateSelectionUI();
})();
</script>
