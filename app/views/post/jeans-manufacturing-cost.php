<?php
  include_once("app/views/shared/header.php");
  require_once("app/controllers/post.controller.php");
  use app\Controllers\PostController;
  if(isset($_GET['user_comment'])){
    $postController = new PostController();
    $postID="1";
    $data = [
      "post_id" => $postID,
      "commenter_name" => $_POST['commenter_name'],
      "post_comment" => $_POST['post_comment'],
    ];
    $addComment = $postController->addComment($data);
    // print_r($addComment);
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
    <?php include_once(dirname(__DIR__). '/shared/tagline.php') ?>
    <div class='col-12 mb-5'>
      <h2 class="h2 text-center mb-5 mt-4 section-heading">Step by step guide to jeans manufacturing cost</h2>
      <p class='mb-4'>Every person knows that jeans are one of the most common apparel everyone uses. Whether it is party dress or worker apparel, jeans are easily worn in every type of clothing. Jeans have their importance. However, clothing brands must know the actual jeans cost, especially when they need custom designing and styling. Production of these jeans involves a complex interplay of material, technology, labor, washing, and packaging costs. Every clothing brand needs competitive jeans manufacturing costs without compromising the quality of jeans. PK Apparel understands all these elements and presents a fair distribution of the cost of manufacturing jeans.</p>
      <h3>Jeans manufacturing cost: The ultimate guide</h3>
      <p class='mb-4'>Welcome to actionable insights and a practical understanding of jeans manufacturing cost. This detailed discussion will teach you how to calculate the cost of jeans manufacturing at the factory.</p>
      <h3>Understand the manufacturing cost from scratch.</h3>
      <p class='mb-4'>Several brands want to get the lowest <strong>jeans manufacturing cost</strong> to make the overall pricing of their clothing competitive. So, we present a fair view of the cost of manufacturing jeans in the factory. This cost is variable as the rate of each factor is not fixed. Here is a complete distribution of the cost incurred to produce one denim and jeans.</p>
      <h3>Jeans manufacturing cost as a whole:</h3>
      <ol>
        <li>Raw material</li>
        <li>Fabric Consumption</li>
        <li>Cutting</li>
        <li>Stitching</li>
        <li>Washing</li>
        <li>Overhead</li>
        <li>Packaging</li>
        <li>Shipping</li>
      </ol>
      <p class='mb-4'>All the costs are discussed in detail in the following discussion, and you will get an idea of each. However, these are the basic costs required to produce denim and jeans.</p>
      <img src="/public/images/posts/jeans-wholesale.jpg" alt="<?php echo $heading ?>" class="img-fluid mb-5" />
      <h3>Step 1: Raw material</h3>
      <h3>What is the raw material for jeans?</h3>
      <p class='mb-4'>The jeans material is created in different versions; sometimes, brands are required to create jeans using 100 percent cotton. So, different denim and jeans fabric variations are available at different prices in the market. The most commonly available type of jeans fabrics are 98% Cotton/2% Spandex, 100% Cotton and 60/40 Cotton/Polyester. Mixing elastane makes the cotton denim fabric more elastic and stretchable. However, elastane, also known as spandex, is used to make cotton more flexible in factories. Here are a few more types of denim fabric.</p>
      <ul>
        <li>Cotton Rayon</li>
        <li>Organic Cotton</li>
        <li>Cotton Spandex</li>
        <li>Cotton+Polyester+Spandex</li>
      </ul>
      <p class='mb-4'>So, every material version varies in cost based on quality and content.</p>
      <h3>Different sizes of jeans and denim for different categories</h3>
      <p class='mb-4'>Everyone knows that jeans and denim are available in several sizes. These sizes vary not only in terms of gender but also in terms of waist sizes. So, a few standard sizes that are available in the market are:</p>
      <h3>Normal Sizes:</h3>
      <p class='mb-4'>28 to 38 are the standard sizes created per the waistband sizes, as it is understood that 28 is the size for the smallest waistband and 38 is for the large waistband.</p>
      <h3>American Sizes:</h3>
      <p class='mb-4'>American sizes, also known as big-size denim, are created for waistband sizes starting from 40 and going to 50. These sizes are created to cater to broader body sizes.</p>
      <h3>Step 2: Fabric consumption</h3>
      <p class='mb-4'>The average consumption for each category must be determined first to determine the cost of denim for various types of denim. So, here we describe average fabric consumption for men, women, boys, and girls.</p>
      <h3>Step 3: Fabric Cost</h3>
      <div class="row section-img mt-5">
        <div class="col-lg-6 col-12 mb-5">
          <img src="/public/images/posts/jeans-manufacturing-cost.jpg" alt="<?php echo $heading ?>" />
        </div>
        <div class="col-lg-6 col-12">
          <p class='mb-4'>Fabric cost, is one of the primary costs in manufacturing jeans. Produced jeans require denim fabric, which we calculate in meters. The cost of 1 meter of jean fabric is 2.14$. So, to find out the cost of fabric for jeans, we need to find out the product of average material consumption and per meter cost of fabric:</p>
        </div>
      </div>
      <p class='mb-3'>These are the primary and raw material costs for denim. On the other hand, if the brands need any unique raw material like cotton denim, then the cost of fabric may vary. </p>
      <h3>Step 4: Fabric Cutting</h3>
      <p class='mb-3'>Fabric is layered on cutting table and cut as per the design and pattern, patterns are put on fabric layer and cutter is used alongside pattern to cut fabric. <br /> There are two costs involved in this step:
        <ul class='pk-list-item mb-3'>
          <li>Pattern Making Cost</li>
          <li>Fabric Cutting Cost</li>
        </ul>
        <p>Cost for above two processes is $0.7 per piece</p>
      </p>
      <h3>Step 5: Stitching</h3>
      <p class='mb-3'>This cost includes labor costs for stitching the denims. This cost also varies based on the efficiency of the factory. If there is automated machinery, stitching costs are lower than those of non-automated processes. A single denim stitching costs 0.21$. So, we need to add the cost of raw material and stitching to get the total cost after stitching. Here is the distribution of cost after stitching.</p>
      <p>So, this is the cost of men&apos;s, women&apos;s, boy&apos;s, and girl&apos;s jeans. After stitching, you need to wash these denims to make them soft and provide them with colors that fit your taste.</p>
      <h3>Step 6: Washing</h3>
      <p class='mb-3'>Now, your denim jeans are ready to wash and colorize. This step is required to achieve the look and texture of denim. Washing is a technique that involves:</p>
      <ul class='pk-list-item'>
        <li>Stone Wash</li>
        <li>Acid Wash</li>
        <li>Enzyme Wash</li>
        <li>Rinse Wash</li>
        <li>Dark Wash</li>
      </ul>
      <p class='mb-3'>The denim wash is a crucial step to achieve the best look, texture, and finish in jeans. Different types of chemicals are used in this step to make the fabric smooth. This process is completed by using a specific amount of water and energy. That is why its cost is also included in the <strong>manufacturing cost of the jeans</strong>. For one pair of jeans, the cost of washing them is almost 0.28$, which is the same for kids and men.</p>
      <p class='mb-3'>Now, your denim and jeans are fully prepared, and if you want to add any accessories, then some additional costs for customization are added to this step as per the client&apos;s need.</p>
      <h3>Step 7: Packaging</h3>
      <p class='mb-3'>It is the right time to pack the denim, and the packaging cost is added to the <strong>jeans manufacturing cost</strong>. The brands need to pay for packaging to provide safety and a proper outlook. So, the packaging cost of each pair of denim is approximately 0.17$.</p>
      <h3>Quality Issurance</h3>
      <p class='mb-3'>However, each pair of jeans and denim must be checked for quality before packaging. At this stage, every jean is individually examined to ensure its quality.</p>
      <h3>Packaging accessories</h3>
      <p class='mb-3'>Packaging not only entails covering, wrapping, and preparing cartons, but it also adds some packaging accessories. Packaging accessories that are common and every brand use it are listed below:</p>
      <ul class='pk-list-item'>
        <li>Labels
          <ul class='pk-list-item'>
            <li>Brand Label</li>
            <li>Care Label</li>
          </ul>
        </li>
        <li>Main Button</li>
        <li>Hang Tag, Price Tag</li>
        <li>Leather Patch</li>
        <li>Polybags</li>
        <li>Carton</li>
        <li>Carton Tape</li>
      </ul>
      <p class='mb-3'>However, packaging accessories are one of the most essential costs because packaging protects your denim until it reaches your destination. So, for every single denim, the cost of packaging accessories is about 0.10$.</p>
      <h3>Step 8: Overhead</h3>
      <p>The overhead cost is also a significant cost that the factory pays. It is not directly spent on jeans and denim but encompasses a range of expenses. All such expenses are needed to run a production facility smoothly. Such indirect expenses are inclusive of:</p>
      <ul class='pk-list-item'>
        <li>Water and Electricity</li>
        <li>Salaries and Administration</li>
        <li>Utilities and rent of space</li>
        <li>Equipment maintenance and supervision</li>
      </ul>
      <p class='mb-3'>So, it is essential to add these costs to the manufacturing cost of jeans. So, here, we will add overhead cost to the cost of jeans after washing.</p>
      <p>After charging this overhead cost, we can get the ex-factory cost. Overhead is the cost you must pay to take your jeans and denim from the factory. On the other hand, if you want your jeans and denim delivered to the nearest port, another expense is added to the cost, which is freight on the boat.</p>
      <h4>Step 9: Shipping</h4>
      <p class='mb-3'>Shipping cost to be added in final cost based on shipping decided shipping terms with client, below are few commonly used shipping terms:
        <ul class='pk-list-item'>
          <li>EXW</li>
          <li>FOB</li>
          <li>CIF</li>
          <li>DDP</li>
        </ul>
      </p>
      <h4>I want to know how much it costs to create jeans.</h4>
      <p class='mb-3'>At PK Apparel, Managing the Cost of jeans is one of our top priorities as we know it would affect the pricing of the brand&apos;s overall apparel. Clothing brands and designers searching for competitive pricing for jeans can consider PK Apparel as we offer highly competitive prices for any jeans. Moreover, the cost of men&apos;s jeans is 4.233$, women&apos;s jeans are 3.591$, the cost of boy&apos;s jeans is 3.163$, and the cost of girl&apos;s jeans is 3.056$.</p>
      <h4>Factors that influence jeans manufacturing cost</h4>
      <div class='mb-3'>Some factors affect the overall cost of jeans and denim. It would help minimize the overall jeans manufacturing cost but also help manage a large volume of jeans production orders. These two costs are inclusive:
        <ul class='pk-list-item'>
          <li>Large order volumes</li>
          <li>Manufacturing capacity</li>
        </ul>
        <p>These are the significant factors that impact the overall cost of jeans production at the factory. So, please place your order with us and get your jeans prepared by experts.</p>
      </div>
    </div>
    <h2 class="section-heading">Jeans Pants Costing (per piece)</h2>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <th></th>
          <th>Fabric Rate</th>
          <th title="fabric consumption in meters">Consumption </th>
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
        </thead>
        <tbody>
          <tr>
            <td>Men</td>
            <td>2.14</td>
            <td>1.30</td>
            <td>2.78</td>
            <td>0.22</td>
            <td>0.11</td>
            <td>0.54</td>
            <td>0.45</td>
            <td>0.15</td>
            <td>0.17</td>
            <td>1.35</td>
            <td>0.15</td>
            <td>$5.92</td>
          </tr>
          <tr>
            <td>Women</td>
            <td>2.14</td>
            <td>1.20</td>
            <td>2.56</td>
            <td>0.22</td>
            <td>0.11</td>
            <td>0.54</td>
            <td>0.45</td>
            <td>0.15</td>
            <td>0.17</td>
            <td>1.35</td>
            <td>0.15</td>
            <td>$5.70</td>
          </tr>
          <tr>
            <td>Boys</td>
            <td>2.14</td>
            <td>0.80</td>
            <td>1.71</td>
            <td>0.22</td>
            <td>0.11</td>
            <td>0.54</td>
            <td>0.45</td>
            <td>0.15</td>
            <td>0.17</td>
            <td>1.35</td>
            <td>0.15</td>
            <td>$4.85</td>
          </tr>
          <tr>
            <td>Girls</td>
            <td>2.14</td>
            <td>0.75</td>
            <td>1.60</td>
            <td>0.22</td>
            <td>0.11</td>
            <td>0.54</td>
            <td>0.45</td>
            <td>0.15</td>
            <td>0.17</td>
            <td>1.35</td>
            <td>0.15</td>
            <td>$4.74</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p class="text-danger mb-5">Note: Above pricing table is based on current material rates and subject to change based on market fluctuation.</p>
    <div class="pk-intro">
      <h2 class="text-center mb-5 h1">PK Apparel</h2>
      <p class="mb-5 h4">You are buyer for any retail chain, wholesaler, retailer and online seller, send us your inquiry and see our non beatable prices and quality. We are serving 25+ customers all over the world since 2015. </p>
      <p class="text-center h2"><a href="/wholesale-shop">See our wholesale shop for men, women, boys and girls garments</a></p>
    </div>
  </div>
  <?php include_once(dirname(__DIR__)."/shared/post-comments.php"); ?>
</div>
<?php include_once(dirname(__DIR__)."/shared/footer.php"); ?>
