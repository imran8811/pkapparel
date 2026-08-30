<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/post.controller.php");
  use app\Controllers\PostController;

  $commentError = '';
  $addComment = null;

  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_comment'])){
    // Honeypot check — bots fill this hidden field, humans leave it empty
    if(!empty($_POST['website'] ?? '')){
      // Silently reject — looks like success to the bot
      $addComment = ['type' => 'success'];
    }
    // Time-gate — reject if form submitted in under 3 seconds
    elseif(isset($_POST['_ts']) && (time() - (int)$_POST['_ts']) < 3){
      $commentError = 'Please wait a moment before submitting.';
    }
    // CSRF check
    elseif(!csrf_verify()){
      $commentError = 'Invalid form submission, please try again.';
    } else {
      $commenter_name = trim($_POST['commenter_name'] ?? '');
      $post_comment   = trim($_POST['post_comment'] ?? '');

      if(empty($commenter_name) || empty($post_comment)){
        $commentError = 'Name and comment are required.';
      } elseif(strlen($commenter_name) > 100){
        $commentError = 'Name is too long (max 100 characters).';
      } elseif(strlen($post_comment) > 2000){
        $commentError = 'Comment is too long (max 2000 characters).';
      } else {
        $postController = new PostController();
        $postID = "1";
        $data = [
          "post_id" => $postID,
          "commenter_name" => $commenter_name,
          "post_comment" => $post_comment,
        ];
        $addComment = $postController->addComment($data);
      }
    }
  }
?>
<div class="container-fluid page-content">
  <div class="row">
    <?php if(isset($addComment)): ?>
    <?php if($addComment['type'] === 'success'){
      echo '<div class="alert alert-success" role="alert">
        Comment has been posted successfully
      </div>';
    };
    ?>
    <?php endif; ?>
    <?php if(!empty($commentError)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($commentError); ?>
      </div>
    <?php endif; ?>
    <?php include_once(dirname(__DIR__). '/shared/tagline.php') ?>
  </div>
</div>

<div class="post-article">

  <!-- Intro -->
  <p class="post-intro">Understanding the true <strong>jeans manufacturing cost</strong> is essential for clothing brands, wholesalers, and retailers looking to price their products competitively. From raw denim fabric to the final packaged pair, every step in the production process adds to the total cost. At PK Apparel, we break down each expense transparently so our clients can plan their pricing strategy with confidence. In this guide, we reveal the actual cost to manufacture a pair of jeans at the factory level.</p>

  <h2 class="mb-3" style="color:#222;">Jeans Manufacturing Cost: Complete Breakdown for 2026</h2>
  <p class="mb-4">The <strong>cost to manufacture jeans</strong> typically ranges between <strong>$4.74 and $5.92 per pair</strong>, depending on the size category, fabric type, and wash technique. This pricing applies to bulk wholesale orders produced in a professional denim factory.</p>
  <p class="mb-4">Whether you are launching a private label denim line or sourcing jeans as a bulk buyer, knowing exactly where your money goes helps you negotiate better deals and maximize profit margins. Below is a step-by-step cost breakdown covering every stage of jeans production — from raw material sourcing to shipping.</p>

  <!-- Table of Contents -->
  <div class="post-toc">
    <h4><i class="fas fa-list me-2"></i>Jeans Manufacturing Cost Breakdown</h4>
    <ol>
      <li><a href="#step1">Raw Material &amp; Denim Fabric Types</a></li>
      <li><a href="#step2">Fabric Consumption Per Category</a></li>
      <li><a href="#step3">Fabric Cost Calculation</a></li>
      <li><a href="#step4">Pattern Making &amp; Fabric Cutting</a></li>
      <li><a href="#step5">Stitching &amp; Sewing</a></li>
      <li><a href="#step6">Washing &amp; Finishing</a></li>
      <li><a href="#step7">Quality Check &amp; Packaging</a></li>
      <li><a href="#step8">Factory Overhead Expenses</a></li>
      <li><a href="#step9">Shipping &amp; Delivery Terms</a></li>
      <li><a href="#cost-table">Full Cost Table (Per Piece)</a></li>
      <li><a href="#factors">Factors That Influence Cost</a></li>
      <li><a href="#faq">Frequently Asked Questions</a></li>
    </ol>
  </div>

  <p class="mb-5">Each cost element is explained in detail below. These figures are based on real production data from our factory and represent the standard costs involved in manufacturing denim jeans at scale.</p>

  <img src="/public/images/posts/jeans-wholesale.jpg" alt="Jeans manufacturing cost breakdown - denim production at wholesale factory" class="img-fluid mb-5" style="border-radius:12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);" />

  <!-- Step 1 -->
  <div class="post-section" id="step1">
    <div class="post-section-header">
      <div class="post-section-badge">1</div>
      <h3>Raw Material — Denim Fabric Types &amp; Their Cost Impact</h3>
    </div>
    <p>The choice of raw material is the single biggest factor in determining the <strong>jeans manufacturing cost</strong>. Denim fabric is available in several compositions, each with different pricing, stretch characteristics, and durability. The most commonly used fabric blends in commercial jeans production are:</p>
    <ul>
      <li><strong>98% Cotton / 2% Spandex</strong> — the most popular blend for stretch jeans, offering comfort with shape retention</li>
      <li><strong>100% Cotton Denim</strong> — traditional rigid denim preferred for workwear and premium raw denim lines</li>
      <li><strong>60% Cotton / 40% Polyester</strong> — a cost-effective blend with added durability, commonly used in budget lines</li>
      <li><strong>Organic Cotton Denim</strong> — higher cost but increasingly demanded by eco-conscious brands</li>
      <li><strong>Cotton + Polyester + Spandex</strong> — tri-blend offering the best balance of stretch, durability, and affordability</li>
    </ul>
    <p>Each fabric composition comes at a different price point. For example, organic cotton denim costs 15–25% more than conventional cotton blends. The fabric you select directly impacts every downstream cost — from consumption to stitching difficulty.</p>

    <h4 style="margin-top:20px; font-size:1.1rem;">Jeans Size Ranges &amp; Fabric Requirement</h4>
    <p>Size ranges affect fabric consumption, which in turn affects cost per pair. Larger sizes require more material, increasing the per-unit <strong>denim manufacturing cost</strong>.</p>
    <div class="row">
      <div class="col-md-6">
        <div class="post-highlight"><i class="fas fa-ruler me-2"></i>Standard Sizes: 28 – 38</div>
        <p>Regular waistband sizes for men and women. Size 28 uses approximately 1.10 meters of fabric, while size 38 may need up to 1.40 meters.</p>
      </div>
      <div class="col-md-6">
        <div class="post-highlight"><i class="fas fa-expand-arrows-alt me-2"></i>Plus / American Sizes: 40 – 50</div>
        <p>Extended sizes for larger body frames. Fabric consumption increases significantly — up to 1.80 meters per pair — which adds $0.50–$1.00 to the manufacturing cost.</p>
      </div>
    </div>
  </div>

  <!-- Step 2 -->
  <div class="post-section" id="step2">
    <div class="post-section-header">
      <div class="post-section-badge">2</div>
      <h3>Fabric Consumption Per Category</h3>
    </div>
    <p>Before calculating the fabric cost, we need to establish how much denim each category of jeans requires. The average fabric consumption (in meters) across standard size ranges is:</p>
    <div class="row text-center mt-3 mb-3">
      <div class="col-6 col-md-3 mb-3"><div class="post-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">1.30 m</strong><small style="color:#555;">Men's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="post-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">1.20 m</strong><small style="color:#555;">Women's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="post-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">0.80 m</strong><small style="color:#555;">Boy's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="post-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">0.75 m</strong><small style="color:#555;">Girl's Jeans</small></div></div>
    </div>
    <p>These consumption values are calculated as averages across the full size range for each category. The actual consumption for any single size may be slightly higher or lower. Fabric wastage during cutting (typically 5–8%) is factored into these figures.</p>
  </div>

  <!-- Step 3 -->
  <div class="post-section" id="step3">
    <div class="post-section-header">
      <div class="post-section-badge">3</div>
      <h3>Fabric Cost — The Largest Component of Jeans Manufacturing Cost</h3>
    </div>
    <div class="row align-items-center">
      <div class="col-lg-6 col-12 mb-4 mb-lg-0">
        <img src="/public/images/posts/jeans-manufacturing-cost.jpg" alt="Denim fabric cost per meter for jeans manufacturing" class="img-fluid" />
      </div>
      <div class="col-lg-6 col-12">
        <p>Fabric cost accounts for roughly <strong>40–50% of the total jeans manufacturing cost</strong>, making it the most significant expense. The current rate for standard denim fabric (12–14 oz, cotton-spandex blend) is <strong>$2.14 per meter</strong>.</p>
        <p>To calculate fabric cost per pair:<br><strong>Fabric Cost = Consumption (meters) × Rate per meter ($2.14)</strong></p>
        <ul>
          <li>Men's: 1.30 × $2.14 = <strong>$2.78</strong></li>
          <li>Women's: 1.20 × $2.14 = <strong>$2.57</strong></li>
          <li>Boy's: 0.80 × $2.14 = <strong>$1.71</strong></li>
          <li>Girl's: 0.75 × $2.14 = <strong>$1.61</strong></li>
        </ul>
      </div>
    </div>
    <p class="mt-3">Premium fabrics such as selvedge denim, organic cotton, or Japanese denim can cost $4–$8 per meter, significantly increasing the overall <strong>cost of making jeans</strong>. Always confirm the fabric specification before finalizing your costing.</p>
  </div>

  <!-- Step 4 -->
  <div class="post-section" id="step4">
    <div class="post-section-header">
      <div class="post-section-badge">4</div>
      <h3>Pattern Making &amp; Fabric Cutting</h3>
    </div>
    <p>Once the fabric is ready, it moves to the cutting department. This stage involves two distinct processes that contribute to the <strong>jeans production cost</strong>:</p>
    <ul>
      <li><strong>Pattern Making ($0.22)</strong> — Creating paper or digital patterns based on the brand's design specifications. Patterns define the shape of each panel: front, back, waistband, pockets, and fly.</li>
      <li><strong>Fabric Cutting ($0.11)</strong> — Denim is layered (up to 80–100 plies) on the cutting table. An electric cutter follows the pattern outlines to cut all layers simultaneously, ensuring uniformity across the batch.</li>
    </ul>
    <div class="post-highlight"><i class="fas fa-tag me-2"></i>Combined pattern + cutting cost: <strong>$0.33 per piece</strong></div>
    <p>Efficient marker planning during cutting can reduce fabric waste by 2–3%, which translates to meaningful savings on large orders of 5,000+ pieces.</p>
  </div>

  <!-- Step 5 -->
  <div class="post-section" id="step5">
    <div class="post-section-header">
      <div class="post-section-badge">5</div>
      <h3>Stitching &amp; Sewing</h3>
    </div>
    <p>Stitching is where the cut fabric panels are assembled into a finished pair of jeans. This process typically involves 30–40 individual sewing operations, including:</p>
    <ul>
      <li>Front and back panel assembly</li>
      <li>Pocket attachment (front slash pockets, back patch pockets, coin pocket)</li>
      <li>Fly and zipper installation</li>
      <li>Waistband attachment and belt loops</li>
      <li>Inseam and outseam stitching</li>
      <li>Hemming and bartacking for reinforcement</li>
    </ul>
    <div class="post-highlight"><i class="fas fa-tag me-2"></i>Stitching cost per pair: <strong>$0.54</strong></div>
    <p>This cost varies by design complexity. Basic 5-pocket jeans have the lowest stitching cost, while cargo styles, decorative stitching, or distressed designs add $0.10–$0.30 per piece. Factories with automated sewing equipment can achieve lower stitching costs due to higher throughput and consistency.</p>
  </div>

  <!-- Step 6 -->
  <div class="post-section" id="step6">
    <div class="post-section-header">
      <div class="post-section-badge">6</div>
      <h3>Washing &amp; Finishing — Achieving the Right Look</h3>
    </div>
    <p>Washing transforms raw stitched jeans into the finished product your customers expect. This step determines the color, softness, and overall aesthetic of the denim. Common wash types used in jeans manufacturing include:</p>
    <ul>
      <li><strong>Rinse Wash</strong> — basic wash to remove starch and soften the fabric; least expensive option</li>
      <li><strong>Stone Wash</strong> — uses pumice stones to create a worn, faded appearance</li>
      <li><strong>Enzyme Wash</strong> — cellulase enzymes break down surface fibers for a soft, vintage feel without using stones</li>
      <li><strong>Acid Wash</strong> — creates high-contrast bleached patterns; popular for fashion-forward styles</li>
      <li><strong>Dark Wash / Overdye</strong> — deepens the indigo color for a clean, premium look</li>
      <li><strong>Bleach Wash</strong> — lightens denim significantly for distressed or summer styles</li>
    </ul>
    <div class="post-highlight"><i class="fas fa-tag me-2"></i>Washing cost per pair: <strong>$0.45</strong> (standard wash, same across all categories)</div>
    <p>Specialty washes like laser finishing or ozone treatment can add $0.15–$0.40 per piece. The washing stage also includes pressing and final ironing to ensure the jeans hold their shape during transit.</p>
  </div>

  <!-- Step 7 -->
  <div class="post-section" id="step7">
    <div class="post-section-header">
      <div class="post-section-badge">7</div>
      <h3>Quality Check &amp; Packaging</h3>
    </div>
    <p>Before any pair leaves the factory, it goes through a multi-point quality inspection and packaging process. This adds two cost components to the <strong>jeans manufacturing cost</strong>:</p>

    <h4 style="margin-top:20px; font-size:1.1rem;">Quality Assurance Inspection</h4>
    <p>Every pair of jeans is individually examined for stitching defects, color consistency, correct sizing, button and zipper functionality, and overall finishing. Factories typically follow AQL (Acceptable Quality Level) standards — AQL 2.5 for major defects and AQL 4.0 for minor defects.</p>

    <h4 style="margin-top:20px; font-size:1.1rem;">Packaging &amp; Accessories</h4>
    <p>Packaging involves folding, tagging, and placing jeans in polybags before carton packing. Standard packaging accessories include:</p>
    <ul>
      <li>Brand label and care/wash label</li>
      <li>Main button and rivets</li>
      <li>Hang tag and price tag</li>
      <li>Leather or embossed patch</li>
      <li>Individual polybag</li>
      <li>Master carton and sealing tape</li>
    </ul>
    <div class="post-highlight"><i class="fas fa-tag me-2"></i>Packaging cost: <strong>$0.17</strong> per pair &nbsp;|&nbsp; Accessories cost: <strong>$0.15</strong> per pair</div>
    <p>Custom branding elements (woven labels, printed tags, embossed leather patches with your logo) are included in the accessories cost at no extra charge for orders above minimum quantity.</p>
  </div>

  <!-- Step 8 -->
  <div class="post-section" id="step8">
    <div class="post-section-header">
      <div class="post-section-badge">8</div>
      <h3>Factory Overhead Expenses</h3>
    </div>
    <p>Overhead costs are indirect expenses required to keep the production facility running. While not tied to a single pair of jeans, these costs are distributed across total production volume. Key overhead expenses include:</p>
    <ul>
      <li><strong>Electricity &amp; Water</strong> — powering sewing machines, washing plants, and lighting</li>
      <li><strong>Factory Rent &amp; Maintenance</strong> — lease cost of production floor, warehouse, and office space</li>
      <li><strong>Salaries &amp; Administration</strong> — management, quality staff, and support personnel</li>
      <li><strong>Equipment Depreciation</strong> — wear and replacement of sewing machines, cutters, and wash equipment</li>
      <li><strong>Compliance &amp; Certifications</strong> — costs of maintaining safety, environmental, and social compliance standards</li>
    </ul>
    <div class="post-highlight"><i class="fas fa-tag me-2"></i>Average overhead per pair: <strong>$1.35</strong></div>
    <p>Overhead cost per unit decreases with larger order volumes. A factory running at higher capacity can spread these fixed costs over more units, which is why bulk orders always result in a lower <strong>jeans manufacturing cost</strong>.</p>
  </div>

  <!-- Step 9 -->
  <div class="post-section" id="step9">
    <div class="post-section-header">
      <div class="post-section-badge">9</div>
      <h3>Shipping &amp; Delivery Terms</h3>
    </div>
    <p>The final cost component depends on the shipping terms (Incoterms) agreed with the buyer. Each term defines who pays for freight, insurance, and customs at different stages of the journey:</p>
    <ul>
      <li><strong>EXW (Ex Works)</strong> — buyer collects from the factory gate; lowest price for the manufacturer</li>
      <li><strong>FOB (Free On Board)</strong> — factory delivers to the port; most common term in garment trade, includes local freight to port</li>
      <li><strong>CIF (Cost, Insurance &amp; Freight)</strong> — factory pays for ocean freight and insurance to the destination port</li>
      <li><strong>DDP (Delivered Duty Paid)</strong> — factory handles everything including import duties and delivery to buyer's warehouse</li>
    </ul>
    <div class="post-highlight"><i class="fas fa-tag me-2"></i>Local shipping to port (FOB basis): <strong>$0.15</strong> per pair</div>
    <p>Most of our clients prefer FOB terms, which adds only a small freight cost. For CIF or DDP shipments, actual costs depend on the destination country, container type (20ft or 40ft), and current freight rates.</p>
  </div>

  <!-- Cost Table -->
  <div class="post-section" id="cost-table">
    <h3 style="color:#2d639e; margin-bottom:15px;"><i class="fas fa-table me-2"></i>Jeans Manufacturing Cost Table (Per Piece)</h3>
    <p>Here is the complete cost breakdown for manufacturing one pair of jeans, categorized by men, women, boys, and girls:</p>
    <div class="table-responsive post-table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>Category</th>
            <th>Fabric Rate</th>
            <th title="fabric consumption in meters">Consumption</th>
            <th title="total fabric cost (rate × consumption)">Fabric Cost</th>
            <th>Patterns</th>
            <th>Cutting</th>
            <th>Stitching</th>
            <th>Washing</th>
            <th title="labels, hangtag, leather patch etc">Accessory</th>
            <th>Packing</th>
            <th title="factory overheads">Overheads</th>
            <th title="to local port">Shipping</th>
            <th><strong>Total</strong></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>Men</strong></td>
            <td>$2.14</td><td>1.30 m</td><td>$2.78</td><td>$0.22</td><td>$0.11</td><td>$0.54</td><td>$0.45</td><td>$0.15</td><td>$0.17</td><td>$1.35</td><td>$0.15</td><td><strong>$5.92</strong></td>
          </tr>
          <tr>
            <td><strong>Women</strong></td>
            <td>$2.14</td><td>1.20 m</td><td>$2.57</td><td>$0.22</td><td>$0.11</td><td>$0.54</td><td>$0.45</td><td>$0.15</td><td>$0.17</td><td>$1.35</td><td>$0.15</td><td><strong>$5.70</strong></td>
          </tr>
          <tr>
            <td><strong>Boys</strong></td>
            <td>$2.14</td><td>0.80 m</td><td>$1.71</td><td>$0.22</td><td>$0.11</td><td>$0.54</td><td>$0.45</td><td>$0.15</td><td>$0.17</td><td>$1.35</td><td>$0.15</td><td><strong>$4.85</strong></td>
          </tr>
          <tr>
            <td><strong>Girls</strong></td>
            <td>$2.14</td><td>0.75 m</td><td>$1.61</td><td>$0.22</td><td>$0.11</td><td>$0.54</td><td>$0.45</td><td>$0.15</td><td>$0.17</td><td>$1.35</td><td>$0.15</td><td><strong>$4.74</strong></td>
          </tr>
        </tbody>
      </table>
    </div>
    <p class="text-muted mb-3" style="font-size:13px;"><i class="fas fa-info-circle me-1"></i>Prices are based on current material rates for standard 12–14 oz cotton-spandex denim. Rates may vary with market fluctuations, fabric type, and order volume.</p>
  </div>

  <!-- Summary -->
  <div class="post-section" style="border-left: 4px solid #2d639e;">
    <h3 style="color:#2d639e; margin-bottom:15px;">How Much Does It Cost to Manufacture Jeans?</h3>
    <p>The total <strong>jeans manufacturing cost</strong> at PK Apparel ranges from $4.74 to $5.92 per pair on an FOB basis. This includes fabric, cutting, stitching, washing, packaging, accessories, overheads, and local shipping. Here is a quick summary:</p>
    <div class="row text-center mt-3">
      <div class="col-6 col-md-3 mb-3"><div class="post-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">$5.92</strong><small style="color:#555;">Men's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="post-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">$5.70</strong><small style="color:#555;">Women's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="post-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">$4.85</strong><small style="color:#555;">Boy's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="post-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">$4.74</strong><small style="color:#555;">Girl's Jeans</small></div></div>
    </div>
    <p>These prices are for standard 5-pocket jeans with basic wash. Custom designs, premium fabrics, or specialty finishes will adjust the final cost accordingly.</p>
  </div>

  <!-- Factors -->
  <div class="post-section" id="factors">
    <h3 style="margin-bottom:15px;">Key Factors That Influence Jeans Manufacturing Cost</h3>
    <p>Several variables determine the final <strong>cost of manufacturing jeans</strong>. Understanding these factors helps brands optimize their sourcing strategy and control costs:</p>
    <ul>
      <li><strong>Order Volume</strong> — Larger orders (5,000+ pieces) significantly reduce the per-unit cost because fixed expenses like pattern making, sampling, and overheads are spread across more units.</li>
      <li><strong>Fabric Selection</strong> — Premium fabrics like organic cotton or selvedge denim can increase fabric cost by 30–60% compared to standard blends.</li>
      <li><strong>Design Complexity</strong> — Cargo jeans, embroidered details, laser distressing, or multiple wash effects increase stitching time and finishing costs.</li>
      <li><strong>Manufacturing Location</strong> — Labor rates vary by country. Countries like Pakistan, Bangladesh, and Vietnam offer competitive manufacturing costs compared to Turkey or China.</li>
      <li><strong>Factory Efficiency</strong> — Automated cutting, advanced sewing lines, and experienced workers reduce waste and speed up production, resulting in lower per-unit costs.</li>
      <li><strong>Seasonal Demand</strong> — Raw material prices, especially cotton, fluctuate with global commodity markets and seasonal demand cycles.</li>
      <li><strong>Compliance Requirements</strong> — Brands requiring certifications like GOTS, OEKO-TEX, or BSCI should account for the compliance overhead in costing.</li>
    </ul>
  </div>

  <!-- FAQ -->
  <div class="post-section post-faq" id="faq">
    <div class="post-section-header">
      <div class="post-section-badge"><i class="fas fa-question"></i></div>
      <h3>Frequently Asked Questions About Jeans Manufacturing Cost</h3>
    </div>

    <div class="faq-list">
      <div class="faq-item">
        <div class="faq-question"><i class="fas fa-dollar-sign me-2"></i> How much does it cost to make one pair of jeans?</div>
        <div class="faq-answer">The cost to make one pair of jeans ranges from <strong>$4.74 to $5.92</strong> at the factory level, depending on the size category (men, women, boys, or girls). This cost includes fabric, cutting, stitching, washing, packaging, accessories, and overheads.</div>
      </div>

      <div class="faq-item">
        <div class="faq-question"><i class="fas fa-boxes me-2"></i> What is the minimum order quantity for jeans manufacturing?</div>
        <div class="faq-answer">Most denim factories require a minimum order of 500–1,000 pieces per style per color. At PK Apparel, we work with brands to accommodate flexible order quantities while keeping the <strong>jeans manufacturing cost</strong> competitive.</div>
      </div>

      <div class="faq-item">
        <div class="faq-question"><i class="fas fa-tshirt me-2"></i> Why is fabric the biggest cost in jeans production?</div>
        <div class="faq-answer">Denim fabric accounts for 40–50% of the total manufacturing cost because cotton is a raw commodity with market-driven pricing, and each pair of jeans requires 0.75–1.30 meters of fabric depending on the size.</div>
      </div>

      <div class="faq-item">
        <div class="faq-question"><i class="fas fa-tag me-2"></i> Can I get jeans manufactured with my own brand label?</div>
        <div class="faq-answer">Yes. Private label and OEM manufacturing is standard in the industry. PK Apparel provides full branding services — woven labels, hang tags, leather patches, custom buttons, and branded packaging — all included in the quoted manufacturing cost.</div>
      </div>

      <div class="faq-item">
        <div class="faq-question"><i class="fas fa-tint me-2"></i> How does wash type affect manufacturing cost?</div>
        <div class="faq-answer">A standard rinse wash is the most affordable option. Specialty finishes like stone wash, acid wash, or laser distressing add $0.15–$0.40 per pair to the base cost.</div>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="post-cta">
    <h2>Get Your Jeans Manufacturing Quote from PK Apparel</h2>
    <p>Whether you are a buyer for a retail chain, wholesaler, private label brand, or online seller — send us your inquiry to receive detailed pricing for your exact specifications. PK Apparel has been manufacturing and exporting quality denim to 25+ clients worldwide since 2015.</p>
    <a href="/" class="btn-cta"><i class="fas fa-store me-2"></i>Visit Our Wholesale Shop</a>
  </div>

</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-12" style="max-width:900px; margin:0 auto;">
      <?php include_once(dirname(__DIR__)."/shared/post-comments.php"); ?>
    </div>
  </div>
</div>
<?php include_once(dirname(__DIR__)."/shared/footer.php"); ?>
