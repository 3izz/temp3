@include('navbar', [
    'extraClass' => 'orange-navbar'
])
<link rel="stylesheet" href="{{asset('faq.css')}}">

 


    <div class="bg-header">
        Frequently Asked Questions
    </div>

    <div class="faq-container">
        <div class="decoration-dots"></div>
        <div class="decoration-circle"></div>

        <div class="faq-item active">
            <div class="faq-question">
                <span>Who is eligible for this program?</span>
                <span class="icon">&minus;</span>
            </div>
            <div class="faq-answer" style="max-height: 100px;"> <p>Any Degree/BTech/BE/MTech final year, Passed outs, Individuals, Employees are eligible for this program.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>What is the duration of the program?</span>
                <span class="icon">&plus;</span>
            </div>
            <div class="faq-answer">
                <p>The program duration varies based on the specific module selected, typically ranging from 3 to 6 months.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Do I get the assured placement?</span>
                <span class="icon">&plus;</span>
            </div>
            <div class="faq-answer">
                <p>We provide 100% placement assistance and interview opportunities with our hiring partners.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>What is the basic academic percentage required?</span>
                <span class="icon">&plus;</span>
            </div>
            <div class="faq-answer">
                <p>A minimum of 50% aggregate in your most recent academic qualification is generally required.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>What is the execution plan of the program?</span>
                <span class="icon">&plus;</span>
            </div>
            <div class="faq-answer">
                <p>The program consists of live sessions, hands-on projects, and mentorship calls.</p>
            </div>
        </div>
        
         <div class="faq-item">
            <div class="faq-question">
                <span>Can we take this course online?</span>
                <span class="icon">&plus;</span>
            </div>
            <div class="faq-answer">
                <p>Yes, this is a fully online program accessible from anywhere.</p>
            </div>
        </div>

    </div>

    <script>
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.icon');

            question.addEventListener('click', () => {
                // Check if currently active
                const isActive = item.classList.contains('active');

                // OPTIONAL: Close all other items (Accordion style)
                // Remove this block if you want multiple items open at once
                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-answer').style.maxHeight = null;
                    otherItem.querySelector('.icon').innerHTML = '&plus;';
                });

                // Toggle current item
                if (!isActive) {
                    item.classList.add('active');
                    answer.style.maxHeight = answer.scrollHeight + "px";
                    icon.innerHTML = '&minus;';
                } else {
                    item.classList.remove('active');
                    answer.style.maxHeight = null;
                    icon.innerHTML = '&plus;';
                }
            });
        });
    </script>
 
 <!-- Header -->
 
 <!-- Footer -->
 @include('footer')