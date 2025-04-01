<div class='col-lg-12 mt-5 mb-5'>
  <div class='row'>
    <form onSubmit={handleSubmit(onSubmit)} autoComplete="off">
      <div class='row mb-3'>
        { currentStepRef.current === 'stepProductInfo' &&
        <>
          <h2 class='text-center mb-5'>Update Product</h2>
          <div class='col-4'>
            <label htmlFor='dept'>Dept.</label>
            <select {...register('dept', { required: true })} class="select-input">
              <option value='men'>Men</option>
              <option value='women'>Women</option>
              <option value='boys'>Boys</option>
              <option value='girls'>Girls</option>
            </select>
          </div>
          <input type='hidden' {...register('p_id')} />
          <div class='col-4 mb-3'>
            <label htmlFor='category'>Category</label>
            <select {...register('category', { required: true })} class="select-input">
              <option value='jeans-pant'>Jeans Pant</option>
              <option value='chino-pant'>Chino Pant</option>
              <option value='cargo-trouser'>Cargo Trouser</option>
              <option value='biker-jeans'>Biker Jeans</option>
            </select>
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='product-name'>Product Name</label>
            <input type="text" id='product-name' {...register('product_name', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='slug'>Slug</label>
            <input type="text" id='slug' {...register('slug', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='article-no'>Article No.</label>
            <input type="text" id='article-no' {...register('article_no', {required: true, valueAsNumber : false})} class='form-control' />
          </div>
          <div class='col-4'>
            <label htmlFor='sizes'>Sizes</label>
            <input type="text" id='sizes' {...register('p_sizes', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='color'>Color</label>
            <input type="text" id='colors' {...register('color', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='fitting'>Fitting</label>
            <select id='fitting' {...register('fitting', { required: true })} class="select-input">
              <option value='slim'>Slim</option>
              <option value='straight'>Straight</option>
              <option value='skinny'>Skinny</option>
              <option value='regular'>Regular</option>
              <option value='ankle'>Ankle</option>
            </select>
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='fabric-type'>Fabric Type</label>
            <input type="text" id='fabric-type' {...register('fabric_type', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='fabric-stretch'>Stretchable</label>
            <select id='fabric-stretch' {...register('fabric_stretch', { required: true })} class="select-input">
              <option value='stretch'>Stretch</option>
              <option value='non-stretch'>Non-stretch</option>
            </select>
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='fabric-weight'>Fabric Weight</label>
            <input type="text" id='fabric-weight' {...register('fabric_weight', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='fabric-content'>Fabric Content</label>
            <input type="text" id='fabric-content' {...register('fabric_content', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='front-fly'>Front Fly</label>
            <select id='front-fly' {...register('front_fly', { required: true })} class="select-input">
              <option value='zipper'>Zipper</option>
              <option value='button'>Button</option>
            </select>
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='wash-type'>Wash Type</label>
            <input type="text" id='wash-type' {...register('wash_type', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='moq'>MOQ</label>
            <input type="text" id='moq' {...register('moq', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='price'>Price</label>
            <input type="text" id='price' {...register('price', {required: true})} class='form-control' />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='piece-weight'>Weight per piece</label>
            <input type="text" id='piece-weight' {...register('piece_weight', {required: true})} class='form-control' />
          </div>
          <div class='d-grid gap-2 pt-4'>
            <button type="submit" class='btn btn-primary btn-block'>Upload Photos</button>
          </div>
        </>
        }
        { currentStepRef.current === 'stepImageUpload' &&
        <>
          <button type='button' class='btn-warning' onClick={()=> {stepChange('stepProductInfo')}}>Back</button>
          <h2 class='text-center mb-5'>Upload Images</h2>
          <div class='col-4 mb-5'>
            <label htmlFor='frontImg' class='mb-2'>Front Image</label>
            <img src={productDetailsRef.current?.image_front} width={200} class='d-block mb-2' />
            <button type='button' class='btn btn-danger' onClick={()=> {deleteBlob(productDetailsRef.current?.image_front)}}>Delete Image</button>
            <input
              type="file"
              id='frontImg'
              class="form-control"
              ref={ProductFrontImageRef}
              multiple
              onChange={(e)=> {uploadImages(e, 'front')}}
            />
          </div>
          <div class='col-4'>
            <label htmlFor='backImg' class='mb-2'>Back Image</label>
            <img src={productDetailsRef.current?.image_back} width={200} class='d-block mb-2' />
            <button type='button' class='btn btn-danger' onClick={()=> {deleteBlob(productDetailsRef.current?.image_back)}}>Delete Image</button>
            <input
              type="file"
              id='backImg'
              class="form-control"
              ref={ProductBackImageRef}
              multiple
              onChange={(e)=> {uploadImages(e, 'back')}}
            />
          </div>
          <div class='col-4'>
            <label htmlFor='other1Img' class='mb-2'>Other 1</label>
            <img src={productDetailsRef.current?.image_side} width={200} class='d-block mb-2' />
            <button type='button' class='btn btn-danger' onClick={()=> {deleteBlob(productDetailsRef.current?.image_side)}}>Delete Image</button>
            <input
              type="file"
              id='other1Img'
              class="form-control"
              ref={ProductOther1ImageRef}
              multiple
              onChange={(e)=> {uploadImages(e, 'other1')}}
            />
          </div>
          <div class='col-4 mb-3'>
            <label htmlFor='other2Img' class='mb-2'>Other 2</label>
            <img src={productDetailsRef.current?.image_other_one} width={200} class='d-block mb-2' />
            <button type='button' class='btn btn-danger' onClick={()=> {deleteBlob(productDetailsRef.current?.image_other_one)}}>Delete Image</button>
            <input
              type="file"
              id='other2Img'
              class="form-control"
              ref={ProductOther2ImageRef}
              multiple
              onChange={(e)=> {uploadImages(e, 'other2')}}
            />
          </div>
          <div class='col-4'>
            <label htmlFor='other3Img' class='mb-2'>Other 3</label>
            <img src={productDetailsRef.current?.image_other_two} width={200} class='d-block mb-2' />
            <button type='button' class='btn btn-danger' onClick={()=> {deleteBlob(productDetailsRef.current?.image_other_two)}}>Delete Image</button>
            <input
              type="file"
              id='other3Img'
              class="form-control"
              ref={ProductOther3ImageRef}
              multiple
              onChange={(e)=> {uploadImages(e, 'other3')}}
            />
          </div>
          <div class='d-grid gap-2 pt-4'>
            <button
              type="button"
              class='btn btn-primary btn-block'
              onClick={()=> router.push('/admin/products')}>Done</button>
          </div>
        </>
        }
      </div>
    </form>
  </div>
  <ToastContainer />
</div>
