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

<style>
  .jmc-article { max-width: 900px; margin: 0 auto; padding: 0 20px; }
  .jmc-article p { font-size: 16px; line-height: 1.8; color: #444; }
  .jmc-intro { font-size: 18px !important; color: #333 !important; border-left: 4px solid #2d639e; padding-left: 20px; background: #f8f9fa; padding: 20px 20px 20px 24px; border-radius: 0 8px 8px 0; margin-bottom: 30px; }

  /* Table of Contents */
  .jmc-toc { background: #fff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 25px 30px; margin-bottom: 40px; }
  .jmc-toc h4 { font-size: 16px; text-transform: uppercase; letter-spacing: 1px; color: #2d639e; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #2d639e; }
  .jmc-toc ol { margin: 0; padding-left: 20px; }
  .jmc-toc ol li { padding: 6px 0; font-size: 15px; }
  .jmc-toc ol li a { color: #333; transition: color 0.2s; }
  .jmc-toc ol li a:hover { color: #2d639e; text-decoration: none !important; }

  /* Step Cards */
  .jmc-step { background: #fff; border-radius: 12px; padding: 30px 30px 25px; margin-bottom: 35px; border: 1px solid #eee; transition: box-shadow 0.3s; }
  .jmc-step:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
  .jmc-step-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
  .jmc-step-badge { flex-shrink: 0; width: 50px; height: 50px; background: linear-gradient(135deg, #2d639e, #1a3f6f); color: #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; }
  .jmc-step-header h3 { margin: 0; font-size: 1.3rem; color: #222; }

  .jmc-step ul, .jmc-step ol { padding-left: 0; list-style: none; margin-bottom: 15px; }
  .jmc-step ul li { position: relative; padding: 6px 0 6px 28px; font-size: 15px; color: #444; }
  .jmc-step ul li::before { content: '\f00c'; font-family: 'Font Awesome 5 Free'; font-weight: 900; position: absolute; left: 0; top: 7px; color: #2d639e; font-size: 13px; }
  .jmc-step ul.jmc-nested { margin-top: 8px; }
  .jmc-step ul.jmc-nested li::before { content: '\f105'; }

  .jmc-step .jmc-highlight { background: #eef4fb; border-radius: 8px; padding: 15px 20px; margin: 15px 0; font-weight: 600; color: #2d639e; font-size: 15px; }

  .jmc-step img { border-radius: 10px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }

  /* Cost Table */
  .jmc-table-wrap { background: #fff; border-radius: 12px; border: 1px solid #eee; overflow: hidden; margin-bottom: 15px; }
  .jmc-table-wrap .table { margin: 0; }
  .jmc-table-wrap thead { background: linear-gradient(135deg, #2d639e, #1a3f6f); }
  .jmc-table-wrap thead th { color: #fff !important; font-size: 13px; font-weight: 600; padding: 14px 12px; border: none; white-space: nowrap; text-align: center; }
  .jmc-table-wrap tbody td { padding: 12px; text-align: center; font-size: 14px; color: #444; vertical-align: middle; border-color: #f0f0f0; }
  .jmc-table-wrap tbody tr:hover { background: #f8f9fa; }
  .jmc-table-wrap tbody td:first-child { font-weight: 700; color: #333; text-align: left; }
  .jmc-table-wrap tbody td:last-child { font-weight: 700; color: #2d639e; font-size: 15px; }

  /* CTA */
  .jmc-cta { background: linear-gradient(135deg, #2d639e 0%, #1a3f6f 100%); border-radius: 16px; padding: 50px 40px; text-align: center; color: #fff; margin: 40px 0; }
  .jmc-cta h2 { font-size: 2rem; margin-bottom: 15px; color: #fff; }
  .jmc-cta p { font-size: 17px; color: rgba(255,255,255,0.92); max-width: 600px; margin: 0 auto 25px; line-height: 1.7; }
  .jmc-cta .btn-cta { display: inline-block; background: #fff; color: #2d639e; padding: 14px 35px; border-radius: 30px; font-weight: 700; font-size: 16px; transition: transform 0.2s, box-shadow 0.2s; }
  .jmc-cta .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.25); text-decoration: none !important; }

  @media (max-width: 767px) {
    .jmc-article { padding: 0 10px; }
    .jmc-step { padding: 20px; }
    .jmc-cta { padding: 30px 20px; }
    .jmc-cta h2 { font-size: 1.5rem; }
    .jmc-table-wrap thead th { font-size: 11px; padding: 10px 6px; }
  }
</style>

<div class="jmc-article">

  <!-- Intro -->
  <p class="jmc-intro">Every person knows that jeans are one of the most common apparel everyone uses. Whether it is party dress or worker apparel, jeans are easily worn in every type of clothing. Clothing brands must know the actual jeans cost, especially when they need custom designing and styling. PK Apparel understands all these elements and presents a fair distribution of the cost of manufacturing jeans.</p>

  <h2 class="mb-3" style="color:#222;">Jeans Manufacturing Cost: The Ultimate Guide</h2>
  <p class="mb-4">Welcome to actionable insights and a practical understanding of jeans manufacturing cost. This detailed discussion will teach you how to calculate the cost of jeans manufacturing at the factory.</p>
  <p class="mb-4">Several brands want to get the lowest <strong>jeans manufacturing cost</strong> to make the overall pricing of their clothing competitive. So, we present a fair view of the cost of manufacturing jeans in the factory. This cost is variable as the rate of each factor is not fixed. Here is a complete distribution of the cost incurred to produce one denim and jeans.</p>

  <!-- Table of Contents -->
  <div class="jmc-toc">
    <h4><i class="fas fa-list me-2"></i>Cost Breakdown Overview</h4>
    <ol>
      <li><a href="#step1">Raw Material</a></li>
      <li><a href="#step2">Fabric Consumption</a></li>
      <li><a href="#step3">Fabric Cost</a></li>
      <li><a href="#step4">Fabric Cutting</a></li>
      <li><a href="#step5">Stitching</a></li>
      <li><a href="#step6">Washing</a></li>
      <li><a href="#step7">Packaging</a></li>
      <li><a href="#step8">Overhead</a></li>
      <li><a href="#step9">Shipping</a></li>
    </ol>
  </div>

  <p class="mb-5">All the costs are discussed in detail in the following discussion, and you will get an idea of each. However, these are the basic costs required to produce denim and jeans.</p>

  <img src="/public/images/posts/jeans-wholesale.jpg" alt="<?php echo $heading ?>" class="img-fluid mb-5" style="border-radius:12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);" />

  <!-- Step 1 -->
  <div class="jmc-step" id="step1">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">1</div>
      <h3>Raw Material — What is the raw material for jeans?</h3>
    </div>
    <p>The jeans material is created in different versions; sometimes, brands are required to create jeans using 100 percent cotton. So, different denim and jeans fabric variations are available at different prices in the market. The most commonly available type of jeans fabrics are 98% Cotton/2% Spandex, 100% Cotton and 60/40 Cotton/Polyester. Mixing elastane makes the cotton denim fabric more elastic and stretchable.</p>
    <ul>
      <li>Cotton Rayon</li>
      <li>Organic Cotton</li>
      <li>Cotton Spandex</li>
      <li>Cotton + Polyester + Spandex</li>
    </ul>
    <p>So, every material version varies in cost based on quality and content.</p>

    <h4 style="margin-top:20px; font-size:1.1rem;">Different sizes of jeans and denim</h4>
    <p>Everyone knows that jeans and denim are available in several sizes. These sizes vary not only in terms of gender but also in terms of waist sizes.</p>
    <div class="row">
      <div class="col-md-6">
        <div class="jmc-highlight"><i class="fas fa-ruler me-2"></i>Normal Sizes: 28 – 38</div>
        <p>Standard sizes created per waistband sizes. 28 is the smallest and 38 is for the large waistband.</p>
      </div>
      <div class="col-md-6">
        <div class="jmc-highlight"><i class="fas fa-expand-arrows-alt me-2"></i>American Sizes: 40 – 50</div>
        <p>Big-size denim created for broader body sizes, starting from waistband 40.</p>
      </div>
    </div>
  </div>

  <!-- Step 2 -->
  <div class="jmc-step" id="step2">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">2</div>
      <h3>Fabric Consumption</h3>
    </div>
    <p>The average consumption for each category must be determined first to determine the cost of denim for various types of denim. So, here we describe average fabric consumption for men, women, boys, and girls.</p>
  </div>

  <!-- Step 3 -->
  <div class="jmc-step" id="step3">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">3</div>
      <h3>Fabric Cost</h3>
    </div>
    <div class="row align-items-center">
      <div class="col-lg-6 col-12 mb-4 mb-lg-0">
        <img src="/public/images/posts/jeans-manufacturing-cost.jpg" alt="<?php echo $heading ?>" class="img-fluid" />
      </div>
      <div class="col-lg-6 col-12">
        <p>Fabric cost is one of the primary costs in manufacturing jeans. Produced jeans require denim fabric, which we calculate in meters. The cost of 1 meter of jean fabric is <strong>$2.14</strong>. To find out the cost of fabric for jeans, we need to find the product of average material consumption and per-meter cost of fabric.</p>
      </div>
    </div>
    <p class="mt-3">These are the primary and raw material costs for denim. On the other hand, if the brands need any unique raw material like cotton denim, then the cost of fabric may vary.</p>
  </div>

  <!-- Step 4 -->
  <div class="jmc-step" id="step4">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">4</div>
      <h3>Fabric Cutting</h3>
    </div>
    <p>Fabric is layered on cutting table and cut as per the design and pattern. Patterns are put on fabric layer and cutter is used alongside pattern to cut fabric. Two costs are involved:</p>
    <ul>
      <li>Pattern Making Cost</li>
      <li>Fabric Cutting Cost</li>
    </ul>
    <div class="jmc-highlight"><i class="fas fa-tag me-2"></i>Cost for above two processes: <strong>$0.70 per piece</strong></div>
  </div>

  <!-- Step 5 -->
  <div class="jmc-step" id="step5">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">5</div>
      <h3>Stitching</h3>
    </div>
    <p>This cost includes labor costs for stitching the denims. This cost also varies based on the efficiency of the factory. If there is automated machinery, stitching costs are lower than those of non-automated processes.</p>
    <div class="jmc-highlight"><i class="fas fa-tag me-2"></i>A single denim stitching costs <strong>$0.21</strong></div>
    <p>After stitching, you need to wash these denims to make them soft and provide them with colors that fit your taste.</p>
  </div>

  <!-- Step 6 -->
  <div class="jmc-step" id="step6">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">6</div>
      <h3>Washing</h3>
    </div>
    <p>Now, your denim jeans are ready to wash and colorize. This step is required to achieve the look and texture of denim. Washing is a technique that involves:</p>
    <ul>
      <li>Stone Wash</li>
      <li>Acid Wash</li>
      <li>Enzyme Wash</li>
      <li>Rinse Wash</li>
      <li>Dark Wash</li>
    </ul>
    <p>The denim wash is a crucial step to achieve the best look, texture, and finish in jeans. Different types of chemicals are used in this step to make the fabric smooth.</p>
    <div class="jmc-highlight"><i class="fas fa-tag me-2"></i>Washing cost per pair: <strong>$0.28</strong> (same for kids and men)</div>
    <p>Now, your denim and jeans are fully prepared, and if you want to add any accessories, then some additional costs for customization are added as per the client's need.</p>
  </div>

  <!-- Step 7 -->
  <div class="jmc-step" id="step7">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">7</div>
      <h3>Packaging</h3>
    </div>
    <p>It is the right time to pack the denim, and the packaging cost is added to the <strong>jeans manufacturing cost</strong>.</p>
    <div class="jmc-highlight"><i class="fas fa-tag me-2"></i>Packaging cost per pair: <strong>$0.17</strong></div>

    <h4 style="margin-top:20px; font-size:1.1rem;">Quality Assurance</h4>
    <p>Each pair of jeans and denim must be checked for quality before packaging. At this stage, every jean is individually examined to ensure its quality.</p>

    <h4 style="margin-top:20px; font-size:1.1rem;">Packaging Accessories</h4>
    <p>Packaging also adds some packaging accessories that every brand uses:</p>
    <ul>
      <li>Labels (Brand Label, Care Label)</li>
      <li>Main Button</li>
      <li>Hang Tag, Price Tag</li>
      <li>Leather Patch</li>
      <li>Polybags</li>
      <li>Carton &amp; Carton Tape</li>
    </ul>
    <div class="jmc-highlight"><i class="fas fa-tag me-2"></i>Packaging accessories cost per piece: <strong>$0.10</strong></div>
  </div>

  <!-- Step 8 -->
  <div class="jmc-step" id="step8">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">8</div>
      <h3>Overhead</h3>
    </div>
    <p>The overhead cost is also a significant cost that the factory pays. It is not directly spent on jeans and denim but encompasses a range of indirect expenses needed to run a production facility smoothly:</p>
    <ul>
      <li>Water and Electricity</li>
      <li>Salaries and Administration</li>
      <li>Utilities and rent of space</li>
      <li>Equipment maintenance and supervision</li>
    </ul>
    <p>After charging this overhead cost, we can get the ex-factory cost. If you want your jeans and denim delivered to the nearest port, another expense is added — freight on the boat.</p>
  </div>

  <!-- Step 9 -->
  <div class="jmc-step" id="step9">
    <div class="jmc-step-header">
      <div class="jmc-step-badge">9</div>
      <h3>Shipping</h3>
    </div>
    <p>Shipping cost to be added in final cost based on shipping terms decided with client. Commonly used shipping terms:</p>
    <ul>
      <li>EXW (Ex Works)</li>
      <li>FOB (Free On Board)</li>
      <li>CIF (Cost, Insurance &amp; Freight)</li>
      <li>DDP (Delivered Duty Paid)</li>
    </ul>
  </div>

  <!-- Summary -->
  <div class="jmc-step" style="border-left: 4px solid #2d639e;">
    <h3 style="color:#2d639e; margin-bottom:15px;">How much does it cost to create jeans?</h3>
    <p>At PK Apparel, managing the cost of jeans is one of our top priorities as we know it would affect the pricing of the brand's overall apparel. Clothing brands and designers searching for competitive pricing for jeans can consider PK Apparel as we offer highly competitive prices.</p>
    <div class="row text-center mt-3">
      <div class="col-6 col-md-3 mb-3"><div class="jmc-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">$5.92</strong><small style="color:#555;">Men's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="jmc-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">$5.70</strong><small style="color:#555;">Women's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="jmc-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">$4.85</strong><small style="color:#555;">Boy's Jeans</small></div></div>
      <div class="col-6 col-md-3 mb-3"><div class="jmc-highlight" style="padding:20px 10px;"><strong style="display:block; font-size:22px;">$4.74</strong><small style="color:#555;">Girl's Jeans</small></div></div>
    </div>
  </div>

  <!-- Factors -->
  <div class="jmc-step">
    <h3 style="margin-bottom:15px;">Factors That Influence Jeans Manufacturing Cost</h3>
    <p>Some factors affect the overall cost of jeans and denim. They help minimize the overall jeans manufacturing cost and manage large volumes of production orders:</p>
    <ul>
      <li>Large order volumes</li>
      <li>Manufacturing capacity</li>
    </ul>
    <p>These are the significant factors that impact the overall cost of jeans production at the factory.</p>
  </div>

  <!-- Cost Table -->
  <h2 style="color:#222; font-size:1.5rem; margin-bottom:15px;"><i class="fas fa-table me-2" style="color:#2d639e;"></i>Jeans Pants Costing (per piece)</h2>
  <div class="table-responsive jmc-table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th></th>
          <th>Fabric Rate</th>
          <th title="fabric consumption in meters">Consumption</th>
          <th title="total fabric cost (rate * consumption)">Fabric Cost</th>
          <th>Patterns</th>
          <th>Cutting</th>
          <th>Stitching</th>
          <th>Washing</th>
          <th title="labels, hangtag, leather patch etc">Accessory</th>
          <th>Packing</th>
          <th title="factory overheads">Overheads</th>
          <th title="to local port">Shipping</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Men</td>
          <td>2.14</td><td>1.30</td><td>2.78</td><td>0.22</td><td>0.11</td><td>0.54</td><td>0.45</td><td>0.15</td><td>0.17</td><td>1.35</td><td>0.15</td><td>$5.92</td>
        </tr>
        <tr>
          <td>Women</td>
          <td>2.14</td><td>1.20</td><td>2.56</td><td>0.22</td><td>0.11</td><td>0.54</td><td>0.45</td><td>0.15</td><td>0.17</td><td>1.35</td><td>0.15</td><td>$5.70</td>
        </tr>
        <tr>
          <td>Boys</td>
          <td>2.14</td><td>0.80</td><td>1.71</td><td>0.22</td><td>0.11</td><td>0.54</td><td>0.45</td><td>0.15</td><td>0.17</td><td>1.35</td><td>0.15</td><td>$4.85</td>
        </tr>
        <tr>
          <td>Girls</td>
          <td>2.14</td><td>0.75</td><td>1.60</td><td>0.22</td><td>0.11</td><td>0.54</td><td>0.45</td><td>0.15</td><td>0.17</td><td>1.35</td><td>0.15</td><td>$4.74</td>
        </tr>
      </tbody>
    </table>
  </div>
  <p class="text-muted mb-5" style="font-size:13px;"><i class="fas fa-info-circle me-1"></i>Note: Above pricing table is based on current material rates and subject to change based on market fluctuation.</p>

  <!-- CTA -->
  <div class="jmc-cta">
    <h2>PK Apparel</h2>
    <p>Whether you are a buyer for a retail chain, wholesaler, retailer, or online seller — send us your inquiry and see our unbeatable prices and quality. We have been serving 25+ customers worldwide since 2015.</p>
    <a href="/" class="btn-cta"><i class="fas fa-store me-2"></i>See Our Wholesale Shop</a>
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
