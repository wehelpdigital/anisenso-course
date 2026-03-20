<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public pages
Route::get('/courses', function () {
    return view('courses.index');
})->name('courses.index');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blog', function () {
    return view('blog.index');
})->name('blog.index');

Route::get('/blog/{slug}', function ($slug) {
    // Temporary articles data
    $articles = [
        'how-to-maximize-your-rice-yield-this-planting-season' => [
            'title' => 'How to Maximize Your Rice Yield This Planting Season',
            'category' => 'Farming Tips',
            'category_color' => 'brand-green',
            'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200&h=600&fit=crop',
            'excerpt' => 'Discover the proven techniques and best practices that have helped thousands of Filipino farmers achieve up to 50% increase in their rice yields.',
            'content' => '
                <p class="lead">Rice farming in the Philippines has been the backbone of our agricultural sector for centuries. With the right techniques and proper knowledge, farmers can significantly increase their yields while maintaining sustainable practices.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1536054454162-6f29ef828e52?w=1000&h=600&fit=crop" alt="Beautiful rice terraces in the Philippines">
                    <figcaption>The famous rice terraces of the Philippines - a testament to our rich farming heritage</figcaption>
                </figure>

                <h2>1. Choose the Right Variety</h2>
                <p>Selecting the appropriate rice variety for your region and climate is crucial. Consider factors like:</p>
                <ul>
                    <li>Drought tolerance for areas with inconsistent rainfall</li>
                    <li>Pest resistance to minimize crop losses</li>
                    <li>Maturity period that fits your planting schedule</li>
                    <li>Yield potential based on your soil conditions</li>
                </ul>

                <blockquote>
                    <p>"The right variety can make or break your harvest. Take time to research what works best in your area before committing to a full planting."</p>
                </blockquote>

                <h2>2. Proper Land Preparation</h2>
                <p>Good land preparation is the foundation of a successful harvest. This includes proper plowing, harrowing, and leveling of the field. A well-prepared field ensures:</p>
                <ul>
                    <li>Even water distribution</li>
                    <li>Better weed control</li>
                    <li>Improved root development</li>
                    <li>Efficient nutrient uptake</li>
                </ul>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&h=400&fit=crop" alt="Farmer plowing field">
                    <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=600&h=400&fit=crop" alt="Prepared agricultural land">
                </div>

                <h2>3. Optimize Your Fertilizer Application</h2>
                <p>Understanding when and how to apply fertilizers can make a significant difference in your yield. The key is to match nutrient application with the crop\'s growth stages.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=1000&h=500&fit=crop" alt="Healthy soil with proper nutrients">
                    <figcaption>Proper soil nutrition is essential for healthy plant growth and maximum yield</figcaption>
                </figure>

                <p>Micronutrient fertilizers like Rhizocote have shown remarkable results in improving plant health and increasing yields by up to 30-50%.</p>

                <h2>4. Water Management</h2>
                <p>Proper water management is essential for rice cultivation. Maintain appropriate water levels during different growth stages:</p>
                <ul>
                    <li>Seedling stage: 2-3 cm water depth</li>
                    <li>Tillering stage: 5-7 cm water depth</li>
                    <li>Flowering stage: 5-10 cm water depth</li>
                    <li>Grain filling: Gradual drainage</li>
                </ul>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1559884743-74a57598c6c7?w=600&h=400&fit=crop" alt="Rice paddy with water">
                    <img src="https://images.unsplash.com/photo-1508193638397-1c4234db14d8?w=600&h=400&fit=crop" alt="Rice field irrigation">
                </div>

                <h2>5. Integrated Pest Management</h2>
                <p>Protect your crops from pests and diseases through integrated pest management (IPM) practices. This combines biological, cultural, and chemical control methods for sustainable pest management.</p>

                <blockquote>
                    <p>"Prevention is always better than cure. Regular field monitoring and early intervention can save your entire harvest."</p>
                </blockquote>

                <figure class="image-full">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1400&h=500&fit=crop" alt="Golden rice field ready for harvest">
                    <figcaption>A healthy rice field approaching harvest time - the result of proper farming techniques</figcaption>
                </figure>

                <h2>Conclusion</h2>
                <p>By implementing these proven techniques, Filipino farmers can significantly improve their rice yields while maintaining sustainable farming practices. Remember, success in farming comes from continuous learning and adaptation to local conditions.</p>
            ',
        ],
        'from-struggling-to-thriving-a-farmers-journey-with-rhizocote' => [
            'title' => 'From Struggling to Thriving: A Farmer\'s Journey with Rhizocote',
            'category' => 'Success Stories',
            'category_color' => 'brand-yellow',
            'image' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=1200&h=600&fit=crop',
            'excerpt' => 'Meet Pedro, a rice farmer from Nueva Ecija who transformed his farm\'s productivity using AniSenso\'s innovative farming techniques.',
            'content' => '
                <p class="lead">Pedro Santos, a 52-year-old rice farmer from Nueva Ecija, had been struggling with declining yields for years. His story of transformation is an inspiration to farmers across the Philippines.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1595841696677-6489ff3f8cd1?w=1000&h=600&fit=crop" alt="Filipino farmer in rice field">
                    <figcaption>Pedro inspecting his thriving rice crops after implementing new farming techniques</figcaption>
                </figure>

                <h2>The Struggle</h2>
                <p>For nearly a decade, Pedro watched his rice yields decline year after year. Despite his best efforts, he couldn\'t figure out what was going wrong. His soil seemed depleted, and traditional fertilizers weren\'t providing the results they once did.</p>

                <blockquote>
                    <p>"I was ready to give up farming altogether. My family had been farming this land for three generations, but I couldn\'t see a future in it anymore."</p>
                </blockquote>

                <h2>Discovering Rhizocote</h2>
                <p>Everything changed when Pedro attended an AniSenso farming seminar in his barangay. There, he learned about Rhizocote and the science behind micronutrient fertilization.</p>
                <p>"At first, I was skeptical," he admits. "I had tried many products before with disappointing results. But the scientific explanation made sense, and I decided to give it one more try."</p>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1591696205602-2f950c417cb9?w=600&h=400&fit=crop" alt="Farming seminar">
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&h=400&fit=crop" alt="Healthy plant roots">
                </div>

                <h2>The Transformation</h2>
                <p>Pedro started using Rhizocote on just one hectare of his farm as a test. The results were visible within weeks:</p>
                <ul>
                    <li>Healthier, more vibrant plants</li>
                    <li>Stronger root systems</li>
                    <li>Better resistance to pests</li>
                    <li>Significantly higher grain count per panicle</li>
                </ul>

                <figure>
                    <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=1000&h=500&fit=crop" alt="Healthy rice plants growing">
                    <figcaption>The visible difference in plant health after using Rhizocote micronutrient fertilizer</figcaption>
                </figure>

                <h2>The Results</h2>
                <p>By harvest time, Pedro\'s test plot yielded 45% more rice than his other fields. He was amazed.</p>

                <blockquote>
                    <p>"I couldn\'t believe my eyes when we weighed the harvest. It was like the old days when our land was still fertile and productive."</p>
                </blockquote>

                <h2>Today</h2>
                <p>Now, Pedro uses Rhizocote on all five hectares of his farm. His yields have consistently improved, and he has become an advocate for modern farming techniques in his community.</p>

                <figure class="image-full">
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1400&h=500&fit=crop" alt="Bountiful harvest">
                    <figcaption>Pedro\'s farm now produces consistently high yields season after season</figcaption>
                </figure>

                <p>"I tell every farmer I meet about my experience," he says. "If I can turn my farm around at my age, anyone can do it."</p>
            ',
        ],
        '5-essential-soil-preparation-techniques-for-better-harvest' => [
            'title' => '5 Essential Soil Preparation Techniques for Better Harvest',
            'category' => 'Farming Tips',
            'category_color' => 'brand-green',
            'image' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=1200&h=600&fit=crop',
            'excerpt' => 'Proper soil preparation is the foundation of a successful harvest. Learn the five techniques that every farmer should know.',
            'content' => '
                <p class="lead">The success of any crop starts with the soil. Proper soil preparation creates the ideal environment for plant growth and can significantly impact your harvest yields.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1585336261022-680e295ce3fe?w=1000&h=600&fit=crop" alt="Rich healthy soil in hands">
                    <figcaption>Healthy soil is the foundation of every successful harvest</figcaption>
                </figure>

                <h2>1. Soil Testing</h2>
                <p>Before any preparation begins, understand your soil\'s current condition through testing. This reveals:</p>
                <ul>
                    <li>pH levels</li>
                    <li>Nutrient content (N-P-K)</li>
                    <li>Micronutrient availability</li>
                    <li>Organic matter content</li>
                </ul>
                <p>Knowing these factors helps you make informed decisions about amendments and fertilizer applications.</p>

                <blockquote>
                    <p>"You can\'t manage what you don\'t measure. Soil testing is the first step to understanding what your crops truly need."</p>
                </blockquote>

                <h2>2. Proper Tillage</h2>
                <p>Tillage breaks up compacted soil and incorporates organic matter. The key is finding the right balance—over-tilling can damage soil structure, while under-tilling may leave the soil too compacted.</p>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1562525369-a3297a4c8b30?w=600&h=400&fit=crop" alt="Tractor tilling soil">
                    <img src="https://images.unsplash.com/photo-1560493676-04071c5f467b?w=600&h=400&fit=crop" alt="Prepared farm field">
                </div>

                <p>For rice paddies, this typically involves:</p>
                <ul>
                    <li>Primary tillage (plowing) to break up soil</li>
                    <li>Secondary tillage (harrowing) to refine soil texture</li>
                    <li>Puddling for proper water retention</li>
                </ul>

                <h2>3. Organic Matter Incorporation</h2>
                <p>Adding organic matter improves soil structure, water retention, and nutrient availability. Common sources include:</p>
                <ul>
                    <li>Rice straw and husks</li>
                    <li>Animal manure</li>
                    <li>Compost</li>
                    <li>Green manure crops</li>
                </ul>

                <figure>
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=1000&h=500&fit=crop" alt="Composting organic matter">
                    <figcaption>Adding organic matter significantly improves soil health and crop productivity</figcaption>
                </figure>

                <h2>4. Proper Leveling</h2>
                <p>A level field ensures even water distribution, which is critical for rice cultivation. Uneven fields lead to:</p>
                <ul>
                    <li>Waterlogged areas where seeds may rot</li>
                    <li>Dry spots where plants struggle</li>
                    <li>Uneven crop maturity</li>
                    <li>Weed problems in shallow areas</li>
                </ul>

                <h2>5. Pre-planting Fertilization</h2>
                <p>Applying basal fertilizer during soil preparation gives your crops a strong start. This includes incorporating micronutrient fertilizers like Rhizocote to address deficiencies that traditional fertilizers miss.</p>

                <figure class="image-full">
                    <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=1400&h=500&fit=crop" alt="Well-prepared agricultural field">
                    <figcaption>A well-prepared field ready for planting - the result of following proper soil preparation techniques</figcaption>
                </figure>

                <h2>Conclusion</h2>
                <p>Investing time in proper soil preparation pays dividends at harvest time. These five techniques form the foundation of successful farming and can help you achieve consistently better yields.</p>
            ',
        ],
        'anisenso-partners-with-da-for-nationwide-farmer-training' => [
            'title' => 'AniSenso Partners with DA for Nationwide Farmer Training',
            'category' => 'News',
            'category_color' => 'blue',
            'image' => 'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=1200&h=600&fit=crop',
            'excerpt' => 'A new partnership aims to bring modern farming techniques to over 100,000 Filipino farmers across all regions.',
            'content' => '
                <p class="lead">In a landmark partnership, AniSenso Academy has joined forces with the Department of Agriculture to launch a comprehensive farmer training program that will reach over 100,000 Filipino farmers nationwide.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=1000&h=600&fit=crop" alt="Partnership signing ceremony">
                    <figcaption>Representatives from AniSenso and the Department of Agriculture during the partnership signing</figcaption>
                </figure>

                <h2>The Partnership</h2>
                <p>The memorandum of agreement was signed at the DA headquarters in Quezon City, with Secretary of Agriculture and AniSenso founder Dr. Ramon Cruz in attendance.</p>

                <blockquote>
                    <p>"This partnership represents a significant step forward in our mission to modernize Philippine agriculture. By combining DA\'s reach with our proven training methodologies, we can make a real difference in the lives of Filipino farmers."</p>
                </blockquote>

                <h2>Program Highlights</h2>
                <p>The training program will cover:</p>
                <ul>
                    <li>Modern farming techniques for rice, corn, and vegetables</li>
                    <li>Proper fertilizer application and soil management</li>
                    <li>Integrated pest management</li>
                    <li>Post-harvest handling and storage</li>
                    <li>Farm business management</li>
                </ul>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1591696205602-2f950c417cb9?w=600&h=400&fit=crop" alt="Farmer training session">
                    <img src="https://images.unsplash.com/photo-1559234938-b60fff04894d?w=600&h=400&fit=crop" alt="Agricultural workshop">
                </div>

                <h2>Implementation</h2>
                <p>The program will be rolled out in phases over the next two years:</p>
                <ul>
                    <li><strong>Phase 1:</strong> Luzon regions (Year 1, Q1-Q2)</li>
                    <li><strong>Phase 2:</strong> Visayas regions (Year 1, Q3-Q4)</li>
                    <li><strong>Phase 3:</strong> Mindanao regions (Year 2, Q1-Q2)</li>
                    <li><strong>Phase 4:</strong> Remote and island communities (Year 2, Q3-Q4)</li>
                </ul>

                <figure>
                    <img src="https://images.unsplash.com/photo-1605000797499-95a51c5269ae?w=1000&h=500&fit=crop" alt="Farmers in training">
                    <figcaption>Farmers attending a hands-on training session in Central Luzon</figcaption>
                </figure>

                <h2>Expected Impact</h2>
                <p>The partnership is expected to:</p>
                <ul>
                    <li>Increase average farm yields by 30-40%</li>
                    <li>Reduce post-harvest losses by 20%</li>
                    <li>Improve farmer income by an average of 35%</li>
                    <li>Create a network of trained agricultural technicians in every province</li>
                </ul>

                <figure class="image-full">
                    <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1400&h=500&fit=crop" alt="Group of farmers in field">
                    <figcaption>Filipino farmers working together towards a more productive future</figcaption>
                </figure>

                <h2>How to Participate</h2>
                <p>Farmers interested in joining the training program can register through their local DA office or through the AniSenso Academy website. Training sessions are free for all registered farmers.</p>
            ',
        ],
        'understanding-micronutrients-what-your-crops-really-need' => [
            'title' => 'Understanding Micronutrients: What Your Crops Really Need',
            'category' => 'Farming Tips',
            'category_color' => 'brand-green',
            'image' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=1200&h=600&fit=crop',
            'excerpt' => 'A comprehensive guide to understanding the role of micronutrients in plant growth and how to identify deficiencies.',
            'content' => '
                <p class="lead">While most farmers are familiar with the major nutrients (Nitrogen, Phosphorus, and Potassium), micronutrients play an equally crucial role in plant health and productivity.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=1000&h=600&fit=crop" alt="Plant leaves showing nutrient health">
                    <figcaption>Healthy plant leaves showing proper nutrient balance - the goal of every farmer</figcaption>
                </figure>

                <h2>What Are Micronutrients?</h2>
                <p>Micronutrients are essential elements that plants need in small quantities. Despite being needed in smaller amounts, their absence can severely limit plant growth and yield. The key micronutrients include:</p>
                <ul>
                    <li><strong>Zinc (Zn)</strong> - Essential for enzyme function and growth hormones</li>
                    <li><strong>Iron (Fe)</strong> - Critical for chlorophyll production</li>
                    <li><strong>Manganese (Mn)</strong> - Important for photosynthesis</li>
                    <li><strong>Boron (B)</strong> - Necessary for cell wall formation</li>
                    <li><strong>Copper (Cu)</strong> - Required for enzyme activation</li>
                    <li><strong>Molybdenum (Mo)</strong> - Essential for nitrogen metabolism</li>
                </ul>

                <blockquote>
                    <p>"Think of micronutrients as vitamins for your plants. Just like humans need vitamins to stay healthy, plants need micronutrients to reach their full potential."</p>
                </blockquote>

                <h2>Signs of Micronutrient Deficiency</h2>
                <p>Learning to recognize deficiency symptoms can help you address problems before they significantly impact your yield:</p>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1597916829826-02e5bb4a54e0?w=600&h=400&fit=crop" alt="Plant showing deficiency">
                    <img src="https://images.unsplash.com/photo-1586771107445-d3ca888129ce?w=600&h=400&fit=crop" alt="Healthy vs unhealthy plant">
                </div>

                <h3>Zinc Deficiency</h3>
                <p>Look for stunted growth, interveinal chlorosis, and small leaves. In rice, zinc deficiency causes "khaira" disease with dusty brown spots on leaves.</p>

                <h3>Iron Deficiency</h3>
                <p>Characterized by yellowing of young leaves while veins remain green. Severe cases show complete bleaching of new growth.</p>

                <h3>Boron Deficiency</h3>
                <p>Causes hollow stems, poor grain fill, and brittle leaves. Often results in poor flowering and fruit set.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=1000&h=500&fit=crop" alt="Soil analysis">
                    <figcaption>Regular soil testing helps identify micronutrient deficiencies before they affect your crops</figcaption>
                </figure>

                <h2>Why Traditional Fertilizers Aren\'t Enough</h2>
                <p>Standard NPK fertilizers don\'t contain micronutrients. Years of intensive farming have depleted soil micronutrient reserves, making supplementation increasingly necessary.</p>

                <h2>The Solution: Micronutrient Fertilizers</h2>
                <p>Products like Rhizocote provide a balanced blend of essential micronutrients in forms that plants can easily absorb. Regular application can:</p>
                <ul>
                    <li>Correct existing deficiencies</li>
                    <li>Prevent future deficiency problems</li>
                    <li>Improve overall plant health</li>
                    <li>Increase yield quantity and quality</li>
                </ul>

                <figure class="image-full">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1400&h=500&fit=crop" alt="Thriving crop field">
                    <figcaption>A field with properly balanced nutrition produces healthier, more productive crops</figcaption>
                </figure>

                <h2>Application Tips</h2>
                <p>For best results, apply micronutrient fertilizers:</p>
                <ul>
                    <li>During soil preparation as basal application</li>
                    <li>As foliar spray during critical growth stages</li>
                    <li>Based on soil test recommendations</li>
                </ul>
            ',
        ],
        'community-farming-how-cooperatives-are-changing-lives' => [
            'title' => 'Community Farming: How Cooperatives are Changing Lives',
            'category' => 'Success Stories',
            'category_color' => 'brand-yellow',
            'image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1200&h=600&fit=crop',
            'excerpt' => 'Discover how farming cooperatives supported by AniSenso are creating sustainable livelihoods for rural communities.',
            'content' => '
                <p class="lead">Across the Philippines, farming cooperatives are proving that working together is the key to agricultural success. These community-based organizations are transforming rural economies and improving the lives of thousands of Filipino farmers.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1593113630400-ea4288922497?w=1000&h=600&fit=crop" alt="Group of farmers working together">
                    <figcaption>Cooperative members working together during harvest season</figcaption>
                </figure>

                <h2>The Power of Cooperation</h2>
                <p>Individual small-scale farmers often struggle with limited resources, lack of bargaining power, and difficulty accessing markets. Cooperatives solve these problems by pooling resources and sharing knowledge.</p>

                <blockquote>
                    <p>"Alone we can do so little; together we can do so much. This has always been the spirit of Filipino farming communities."</p>
                </blockquote>

                <h2>San Jose Farmers Cooperative: A Model of Success</h2>
                <p>The San Jose Farmers Cooperative in Pangasinan started with just 25 members in 2018. Today, it has grown to over 200 members and has become a model for other communities.</p>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1595841696677-6489ff3f8cd1?w=600&h=400&fit=crop" alt="Cooperative meeting">
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&h=400&fit=crop" alt="Farmers in field">
                </div>

                <h3>Key Achievements:</h3>
                <ul>
                    <li>Collective purchase of inputs reduced costs by 30%</li>
                    <li>Shared equipment eliminated the need for individual expensive purchases</li>
                    <li>Direct market access increased farmer income by 40%</li>
                    <li>Group training programs improved farming techniques across all members</li>
                </ul>

                <h2>AniSenso\'s Role</h2>
                <p>AniSenso has partnered with cooperatives across the country to provide:</p>
                <ul>
                    <li>Technical training for members</li>
                    <li>Access to quality inputs at cooperative prices</li>
                    <li>Ongoing support from agricultural technicians</li>
                    <li>Connections to markets and buyers</li>
                </ul>

                <figure>
                    <img src="https://images.unsplash.com/photo-1591696205602-2f950c417cb9?w=1000&h=500&fit=crop" alt="Training session">
                    <figcaption>AniSenso conducting a training session for cooperative members</figcaption>
                </figure>

                <h2>Impact Stories</h2>

                <blockquote>
                    <p>"Before joining the cooperative, I was farming alone and barely breaking even. Now, my income has doubled, and I can send my children to college." — Maria, 45, Cooperative Member</p>
                </blockquote>

                <blockquote>
                    <p>"The training we received from AniSenso changed everything. Our members now use modern techniques that our grandparents never knew about." — Jose, 60, Cooperative Chairman</p>
                </blockquote>

                <figure class="image-full">
                    <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=1400&h=500&fit=crop" alt="Prosperous farmland">
                    <figcaption>The collective success of cooperative farming leads to prosperous communities</figcaption>
                </figure>

                <h2>Starting Your Own Cooperative</h2>
                <p>Interested in forming a farming cooperative in your community? Here are the basic steps:</p>
                <ol>
                    <li>Gather at least 15 interested farmers</li>
                    <li>Register with the Cooperative Development Authority</li>
                    <li>Develop bylaws and elect officers</li>
                    <li>Start with small collective activities</li>
                    <li>Gradually expand services as the cooperative grows</li>
                </ol>
                <p>Contact AniSenso Academy to learn more about our cooperative support programs.</p>
            ',
        ],
        '2026-planting-calendar-best-times-for-major-crops' => [
            'title' => '2026 Planting Calendar: Best Times for Major Crops',
            'category' => 'News',
            'category_color' => 'blue',
            'image' => 'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?w=1200&h=600&fit=crop',
            'excerpt' => 'Plan your year with our comprehensive planting calendar, featuring optimal dates for rice, corn, vegetables, and more.',
            'content' => '
                <p class="lead">Timing is everything in farming. Planting at the right time can mean the difference between a bumper harvest and a disappointing yield. Here\'s your comprehensive guide to planting schedules for 2026.</p>

                <figure>
                    <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=1000&h=600&fit=crop" alt="Calendar and farming planning">
                    <figcaption>Planning your planting schedule is essential for maximizing yields</figcaption>
                </figure>

                <h2>Rice (Palay)</h2>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1536054454162-6f29ef828e52?w=600&h=400&fit=crop" alt="Rice seedlings">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600&h=400&fit=crop" alt="Rice field">
                </div>

                <h3>Wet Season Crop</h3>
                <ul>
                    <li><strong>Seed bed preparation:</strong> May 15 - June 15</li>
                    <li><strong>Transplanting:</strong> June 15 - July 15</li>
                    <li><strong>Expected harvest:</strong> October - November</li>
                </ul>

                <h3>Dry Season Crop</h3>
                <ul>
                    <li><strong>Seed bed preparation:</strong> November 1 - December 15</li>
                    <li><strong>Transplanting:</strong> December 15 - January 15</li>
                    <li><strong>Expected harvest:</strong> April - May</li>
                </ul>

                <blockquote>
                    <p>"The right timing combined with proper nutrition can increase your rice yield by up to 40%. Plan ahead and prepare your inputs before planting season begins."</p>
                </blockquote>

                <h2>Corn (Mais)</h2>

                <figure>
                    <img src="https://images.unsplash.com/photo-1601593346740-925612772716?w=1000&h=500&fit=crop" alt="Corn field">
                    <figcaption>Healthy corn crop planted during the optimal season</figcaption>
                </figure>

                <h3>Wet Season</h3>
                <ul>
                    <li><strong>Planting:</strong> May - June</li>
                    <li><strong>Harvest:</strong> August - September</li>
                </ul>

                <h3>Dry Season</h3>
                <ul>
                    <li><strong>Planting:</strong> October - November</li>
                    <li><strong>Harvest:</strong> January - February</li>
                </ul>

                <h2>Vegetables</h2>

                <div class="image-grid">
                    <img src="https://images.unsplash.com/photo-1592921870789-04563d55041c?w=600&h=400&fit=crop" alt="Tomatoes growing">
                    <img src="https://images.unsplash.com/photo-1518977956812-cd3dbadaaf31?w=600&h=400&fit=crop" alt="Eggplants">
                </div>

                <h3>Tomatoes</h3>
                <ul>
                    <li><strong>Best planting:</strong> September - November</li>
                    <li><strong>Harvest:</strong> 60-80 days after transplanting</li>
                </ul>

                <h3>Eggplant</h3>
                <ul>
                    <li><strong>Best planting:</strong> Year-round (avoid heavy rains)</li>
                    <li><strong>Harvest:</strong> 70-90 days after transplanting</li>
                </ul>

                <h3>String Beans (Sitaw)</h3>
                <ul>
                    <li><strong>Best planting:</strong> September - February</li>
                    <li><strong>Harvest:</strong> 50-60 days after planting</li>
                </ul>

                <figure class="image-full">
                    <img src="https://images.unsplash.com/photo-1595841696677-6489ff3f8cd1?w=1400&h=500&fit=crop" alt="Bountiful harvest">
                    <figcaption>A successful harvest is the result of proper planning and timing</figcaption>
                </figure>

                <h2>Important Reminders</h2>
                <ul>
                    <li>Always check local weather forecasts before planting</li>
                    <li>Adjust schedules based on your specific location and elevation</li>
                    <li>Prepare soil 2-3 weeks before target planting date</li>
                    <li>Have micronutrient fertilizers like Rhizocote ready for application</li>
                </ul>

                <h2>Download the Full Calendar</h2>
                <p>Get our complete 2026 Planting Calendar with detailed schedules for over 30 crops. Available free for all AniSenso Academy members.</p>
            ',
        ],
    ];

    // Find the article
    if (!isset($articles[$slug])) {
        abort(404);
    }

    $article = $articles[$slug];
    $article['slug'] = $slug;

    // Get related articles (exclude current)
    $relatedArticles = collect($articles)->except($slug)->take(3);

    return view('blog.show', compact('article', 'relatedArticles'));
})->name('blog.show');

Route::get('/unladsaka-rhizocote-micronutrient-fertilizer-for-crops-high-yield', function () {
    return view('tech.rhizocote');
})->name('tech.rhizocote');

Route::get('/get-online-course', function () {
    return view('courses.online-course');
})->name('courses.online');

Route::get('/join-community', function () {
    return view('community.join');
})->name('community.join');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/step-1', [CheckoutController::class, 'stepOnePage'])->name('checkout.step1.page');
Route::get('/checkout/step-2', [CheckoutController::class, 'stepTwoPage'])->name('checkout.step2.page');
Route::get('/checkout/continue/{token}', [CheckoutController::class, 'continueCheckout'])->name('checkout.continue');
Route::post('/checkout/step-1', [CheckoutController::class, 'stepOne'])->name('checkout.step1');
Route::post('/checkout/step-2', [CheckoutController::class, 'stepTwo'])->name('checkout.step2');
Route::post('/checkout/step-3', [CheckoutController::class, 'stepThree'])->name('checkout.step3');
Route::post('/checkout/login', [CheckoutController::class, 'loginExistingAccount'])->name('checkout.login');
Route::post('/checkout/check-email', [CheckoutController::class, 'checkEmailExists'])->name('checkout.check-email');
Route::get('/checkout/reset', [CheckoutController::class, 'resetCheckout'])->name('checkout.reset');
Route::get('/checkout/salamat/{token}', [CheckoutController::class, 'showConfirmation'])->name('checkout.confirmation');

// Guest routes (not authenticated)
Route::middleware('guest:client')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    // Password Reset Routes (Email OTP)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.verify-otp');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp.submit');
    Route::get('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.resend-otp');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
    Route::get('/cancel-reset', [ForgotPasswordController::class, 'cancel'])->name('password.cancel');
});

// Authenticated routes
Route::middleware('auth:client')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
