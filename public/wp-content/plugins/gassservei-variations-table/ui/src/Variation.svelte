<script>
  import Spinner from "./Spinner.svelte";
  import TickIcon from "./TickIcon.svelte";
  export let columns;
  export let item;
  export let attributes;
  export let productImageURL;
  export let textVars;
  export let showSpinner;
  let addToCartBtn;
  let quantity = 1;
  let added = false;
  let loading = false;
  let quantityForm;
  function imageURL(image) {
    var imageURL = "";
    if (image) {
      imageURL = image;
    } else {
      imageURL = productImageURL;
    }
    return imageURL;
  }
  function imageClass(image) {
    var imageURL = "";
    if (image) {
      imageURL = image;
    } else {
      imageURL = productImageURL;
    }
    let imageClass = imageURL.split("/");
    imageClass = imageClass[imageClass.length - 1]
      .split(".")[0]
      .replace(/\s+/g, "");
    return imageClass;
  }

  function findVariationAttrValByKey(key) {
    const varAttr = item.attributes[`attribute_${key}`];

    if (varAttr === undefined) {
      return false;
    }
    return varAttr;
  }
  function getAttributeNameFromSlug(slug, options) {
    const attrSlug = findVariationAttrValByKey(slug);
    let AttrName = options.find((option) => option.slug === attrSlug);
    if (!AttrName || !AttrName.name) return "";
    return AttrName.name;
  }
  function minusOne(){
    if(quantityForm && item.min_qty == quantity){
      return;
    }else{
      quantity = quantity - 1;
    }
  }
  function plusOne(){
    if(quantityForm && (item.max_qty && item.max_qty == quantity)){
      return;
    }else{
      quantity = quantity + 1;
    }
  }
  function addToCart() {
    if (
      quantityForm &&
      (item.min_qty > quantity || (item.max_qty && item.max_qty < quantity))
    ) {
      quantityForm.reportValidity();
      return;
    }
    const productData = {
      product_id: item.variation_id,
      variation_id: item.variation_id,
      quantity,
    };
    const data = Object.assign(item.attributes, productData);
    jQuery(document.body).trigger("adding_to_cart", [
      jQuery(addToCartBtn),
      data,
    ]);
    jQuery.ajax({
      type: "POST",
      url: woocommerce_params.wc_ajax_url
        .toString()
        .replace("%%endpoint%%", "add_to_cart"),
      data,
      beforeSend: function (response) {
        added = false;
        loading = true;
      },
      complete: function (response) {
        loading = false;
      },
      success: function (response) {
        if (response.error && response.product_url) {
          window.location = response.product_url;
          return;
        }

        // Redirect to cart option
        if (wc_add_to_cart_params.cart_redirect_after_add === "yes") {
          window.location = wc_add_to_cart_params.cart_url;
          return;
        }

        added = true;

        jQuery(document.body).trigger("added_to_cart", [
          response.fragments,
          response.cart_hash,
          jQuery(addToCartBtn),
        ]);
      },
    });
  }
</script>

<tr
  class="variation-{item.variation_id} image-{imageClass(item['image_link'])}"
>
  {#each columns as column, i}
    {#if column.active === "on"}
      {#if column.key !== "attributes" && column.key !== "quantity" && column.key !== "link"}
        <td data-title={column.title} class="{column.key}">
          <div>
            {#if column.type === "image"}
              <span class="item">
                {#if imageURL(item[column.key]) != ""}
                  <img src={imageURL(item[column.key])} alt={item.sku} />
                {/if}
              </span>
            {/if}
            {#if column.type === "text"}
              <span class="item">{item[column.key]}</span>
            {/if}
            {#if column.type === "html"}
              <span class="item">
                {@html item[column.key]}
              </span>
            {/if}
            {#if column.type === "stock"}
              <span class="item">
                {#if item[column.key]}
                  <span
                    class:in-stock={item["is_in_stock"]}
                    class:out-of-stock={!item["is_in_stock"]}
                  >
                    {@html item["availability_html"]}
                  </span>
                {/if}
              </span>
            {/if}
          </div>
        </td>
      {:else if column.key === "link"}
        <td class="link">
          <a
            class="button alt"
            class:added
            class:loading
            href={item.product_url}
          >
            <span class="spk-icon-arrow-right"></span>
            {textVars.link}
          </a>
        </td>
      {:else if column.key === "quantity"}
        <td class="quantity">
          <div>
            {#if item["is_in_stock"]}
              <form action="#" bind:this={quantityForm} class="variable-cart">
                <span class="minus" on:click={minusOne}>-</span>
                <input
                  bind:value={quantity}
                  type="number"
                  step="1"
                  min={item.min_qty}
                  max={item.max_qty}
                  name="quantity"
                  data-title="Qty"
                  title="Qty"
                  class="input-text qty text"
                  size="4"
                  pattern="[0-9]*"
                  inputmode="numeric"
                />
                <span class="plus" on:click={plusOne}>+</span>
              </form>
            {/if}
            <span
              class:in-stock={item["is_in_stock"]}
              class:out-of-stock={!item["is_in_stock"]}
            >
              {@html item["availability_html"]}
            </span>
            {#if item["distributor_offer"]}
            {@html item["distributor_offer_html"]}
            {/if}
          </div>
        </td>
      {:else}
        {#each attributes as attr, i}
          {#if attr.visible && attr.key!=='pa_ean'}
            <td data-title={attr.name}>
              <div>
                {getAttributeNameFromSlug(attr.key, attr.options)}
              </div>
            </td>
          {/if}
        {/each}
      {/if}
    {/if}
  {/each}
  <td class="add-to-cart">
    <button
      bind:this={addToCartBtn}
      on:click={addToCart}
      type="submit"
      disabled={!item["is_in_stock"] || !item["is_purchasable"]}
      class="single_add_to_cart_button button alt ajax_add_to_cart"
      class:added
      class:loading
      data-quantity="1"
    >
      {textVars.addToCartText}
      {#if loading && showSpinner === "on"}
        <Spinner />
      {/if}
      {#if !loading && added && showSpinner === "on"}
        <TickIcon />
      {/if}
    </button>
  </td>
</tr>
