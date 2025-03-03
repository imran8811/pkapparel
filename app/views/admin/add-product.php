<?php include_once __DIR__ ."/admin-header.php"; ?>
<div class='container-fluid mt-5 mb-5'>
  <div class='row justify-content-center'>
    <form action="/admin/add-product" method="post">
      <div class='row mb-3'>
        <h2 class='text-center mb-5'>Add Product</h2>
        <div class='col-4'>
          <label for='dept'>Dept.</label>
          <select id="dept" class="select-input">
            <option value='men'>Men</option>
            <option value='women'>Women</option>
            <option value='boys'>Boys</option>
            <option value='girls'>Girls</option>
          </select>
        </div>
        <div class='col-4 mb-3'>
          <label for='category'>Category</label>
          <select id="category" class="select-input">
            <option value='jeans-pant'>Jeans Pant</option>
            <option value='chino-pant'>Chino Pant</option>
            <option value='cargo-trouser'>Cargo Trouser</option>
            <option value='biker-jeans'>Biker Jeans</option>
          </select>
        </div>
        <div class='col-4 mb-3'>
          <label for='article-no'>Article No.</label>
          <input type="text" id='article-no' class='form-control' />
        </div>
        <div class='col-4'>
          <label for='sizes'>Sizes</label>
          <input type="text" id='sizes' class='form-control' />
        </div>
        <div class='col-4 mb-3'>
          <label for='color'>Color</label>
          <input type="text" id='colors' class='form-control' />
        </div>
        <div class='col-4 mb-3'>
          <label for='fitting'>Fitting</label>
          <select id='fitting' class="select-input">
            <option value='slim'>Slim</option>
            <option value='straight'>Straight</option>
            <option value='skinny'>Skinny</option>
            <option value='regular'>Regular</option>
            <option value='ankle'>Ankle</option>
          </select>
        </div>
        <div class='col-4 mb-3'>
          <label for='fabric-type'>Fabric Type</label>
          <input type="text" id='fabric-type' class='form-control' />
        </div>
        <div class='col-4 mb-3'>
          <label for='fabric-stretch'>Stretchable</label>
          <select id='fabric-stretch' class="select-input">
            <option value='stretch'>Stretch</option>
            <option value='non-stretch'>Non-stretch</option>
          </select>
        </div>
        <div class='col-4 mb-3'>
          <label for='fabric-weight'>Fabric Weight</label>
          <input type="text" id='fabric-weight' class='form-control' />
        </div>
        <div class='col-4 mb-3'>
          <label for='fabric-content'>Fabric Content</label>
          <input type="text" id='fabric-content' class='form-control' />
        </div>
        <div class='col-4 mb-3'>
          <label for='front-fly'>Front Fly</label>
          <select id='front-fly' class="select-input">
            <option value='zipper'>Zipper</option>
            <option value='button'>Button</option>
          </select>
        </div>
        <div class='col-4 mb-3'>
          <label for='wash-type'>Wash Type</label>
          <input type="text" id='wash-type' class='form-control' />
        </div>
        <div class='col-4 mb-3'>
          <label for='moq'>MOQ</label>
          <input type="text" id='moq' class='form-control' />
        </div>
        <div class='col-4 mb-3'>
          <label for='price'>Price</label>
          <input type="text" id='price' class='form-control' />
        </div>
        <div class='col-4 mb-3'>
          <label for='piece-weight'>Weight per piece</label>
          <input type="text" id='piece-weight' class='form-control' />
        </div>
        <div class='col-4 mb-5'>
          <label for='frontImg'>Front Image</label>
          <input type="file" id='frontImg' class="form-control" />
        </div>
        <div class='col-4'>
          <label for='backImg'>Back Image</label>
          <input type="file" id='backImg' class="form-control" />
        </div>
        <div class='col-4'>
          <label for='other1Img'>Other 1</label>
          <input type="file" id='otheriImg' class="form-control" />
        </div>
        <div class='col-4 mb-3'>
          <label for='other2Img'>Other 2</label>
          <input type="file" id='other2Img' class="form-control" />
        </div>
        <div class='col-4'>
          <label for='other3Img'>Other 3</label>
          <input type="file" id='other3Img' class="form-control" />
        </div>
        <div class='d-grid gap-2 pt-4'>
          <button type="submit" class='btn btn-primary btn-block'>Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include_once __DIR__ ."/admin-footer.php"; ?>
