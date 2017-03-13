<template>
  <div>
    <hero :title="this.$root.trans.translate('promomateriaal')" :hasSubtitle="true" :subtitle="this.$root.trans.translate('Bestel hier uw promomateriaal')" type="is-blue"></hero>
    <info-panel :orderPrice="totalPrice"></info-panel>

    <div class="container mb-50">    

      <modal 
      v-if="showConfirmationModal" 
      @close="showConfirmationModal = false"
      @modalconfirmed="placeOrder"
      :hasYesNoOptions="true"
      :body="this.$root.trans.translate('Bent u zeker dat u deze bestelling wilt plaatsen?')"
      >
    </modal>

    <notification></notification>

  <!-- <alert v-if="showAlert" @close="showAlert = false">
    Klik bij een product op 'toevoegen' om deze aan uw bestelling toe te voegen. 
    Bent u klaar? Klik dan op 'Bestelling plaatsen' om de bestelling vast te leggen.
  </alert> -->

  <section class="section" v-if="orderlist.length > 0">
    <ul class="cart-list">
      <li v-for="item in orderlist" class="slideInLeft">
        <div class="cart-item-segment">
          <div class="cart-item-amount card-info-item">
            {{ item.amount }}
            <span class="anim-circle"></span>
          </div>
          <div class="cart-item-info-name card-info-item">
            <span v-translate-name="item.product"></span>
          </div>
          <div class="cart-item-info-pack card-info-item">
            {{ $root.trans.translate('pakket van') }} {{ item.product.pack }} {{ $root.trans.translate('stuks') }}
          </div>
          <div class="cart-item-info-stock card-info-item">
            {{ item.product.stock - item.amount }} {{ $root.trans.translate('in stock') }}
          </div>
          <div class="cart-item-info-price card-info-item">
            {{ '€' + calculateTotalPriceForItemInOrder(item).toFixed(2) }}
          </div>
          <div class="cart-item-controls">
            <a class="button button-round is-primary spin-icon" :disabled="item.amount == 1" @click="decreaseAmount(item)">
              <span class="icon is-small has-icon">
                <i class="fa fa-minus"></i>
              </span>
            </a>
            <a class="button button-round is-primary spin-icon" :disabled="item.stock <= 0" @click="addItemToOrder(item.product)">
              <span class="icon is-small has-icon">
                <i class="fa fa-plus"></i>
              </span>
            </a>
            <a class="button button-round is-danger transitioning-icon" @click="removeItemFromOrder(item)">
              <span class="icon is-small has-stacked-icons has-animation">
                <i class="fa fa-remove"></i>
                <i class="fa fa-trash"></i>
              </span>
            </a>
          </div>
        </div>
      </li>
    </ul>
    <div class="cart-item-segment cart-list-summary" v-if="orderlist.length >= 1">
      <p>{{ $root.trans.translate('totaalprijs') }} <strong>€ {{ totalPrice.toFixed(2) }}</strong></p>
      <button class="button is-primary pull-right" @click="showConfirmationModal = true">{{ $root.trans.translate('Bestelling plaatsen') }}</button>
    </p>
  </div>
</section>

  <h3 class="title is-title-centered-message">{{ $root.trans.translate('Beschikbare producten') }}</h3>

<div class="products">

  <div class="single-product-card" v-for="item in promomateriaal">
    <h3 class="has-text-centered">
    <span v-translate-name="item"></span>
      {{ $root.trans.translate('per') + " " + item.pack + " " + $root.trans.translate('stuks') }}.
    </h3>
    <div class="single-product-card-image">
      <img :src="'/images/promomateriaal/'+item.image+'.png'" alt="">
    </div>
    <div class="single-product-card-info">
    <div class="card-info-item">
      {{ item.stock + " " + $root.trans.translate('in stock')}} 
    </div>
    <div class="card-info-item">
      {{ '€' + (item.price / 100).toFixed(2) }}
    </div>
      <div class="card-info-item">
        <a class="button button-round is-blue transitioning-icon" @click="addItemToOrder(item)">
          <span class="icon is-small has-stacked-icons has-animation">
            <i class="fa fa-shopping-cart"></i>
            <i class="fa fa-plus"></i>
          </span>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="is-clearfix"></div>
</div>
</div>
</template>

<script>
  export default {
    mounted() {
      this.totalPrice = 0;
      this.fetchItemsInStock();
      this.fetchUser();
    },
    data(){
      return {
        promomateriaal: [],
        orderlist: [],
        totalPrice: 0,
        showAlert: true,
        showConfirmationModal: false,
        user: ''
      }
    },
    computed:{

    },
    methods: {
      checkBudget(item){
        return ((this.user.budget / 100) - (this.totalPrice + (item.price / 100) ) <= 0) ? false : true;
      },  
      fetchUser(){
        this.$http.get('/userdata').then((response) => {
          this.user = response.body;
        });
      },
      fetchItemsInStock(){
        Event.$emit('start-loading');
        this.$http.get('/promomateriaal/get').then((response) => {
          this.promomateriaal = response.body;
          this.$nextTick(() => {
            $('.products').imagesLoaded( function() {
              $('.products').masonry();
              Event.$emit('data-loaded');
            });
          });
        });
      },
      addItemToOrder(item){
        if(this.checkBudget(item)){
          var ordereditem = this.findItemInOrderList(item);
          if(!ordereditem){
            var stock = item.stock;
            this.orderlist.push({'product': item, 'amount': 1, 'stock': stock-1});
            Event.$emit('itemAddedToCart', { 'message': this.$root.trans.translate('Het gekozen product werd toegevoegd aan uw winkelmandje') });
          }else{
            this.increaseAmount(ordereditem);
          }
          this.calculateTotalPriceForOrder();
        }else{
          Event.$emit('not-enough-budget');
        }
      },
      removeItemFromOrder(item){
        this.orderlist.splice(this.orderlist.indexOf(item), 1);
        this.calculateTotalPriceForOrder();
        Event.$emit('itemRemovedFromCart', { 'message': this.$root.trans.translate('Het gekozen product werd verwijderd uit uw winkelmandje') });
      },
      increaseAmount(item){
        if(item.stock > 0){
          item.amount++;
          item.stock--;
          this.animateAmount(item);
        }
        this.calculateTotalPriceForOrder();
      },
      decreaseAmount(item){
        if(item.amount > 1){
          item.amount--;
          item.stock++;
          this.animateAmount(item);
        }
        this.calculateTotalPriceForOrder();
      },
      calculateTotalPriceForItemInOrder(item){
        return ((item.product.price / 100) * item.amount);
      },
      calculateTotalPriceForOrder(){
        this.totalPrice = 0;
        _.forEach(this.orderlist, (item) => {
          this.totalPrice += this.calculateTotalPriceForItemInOrder(item);
        });
      },
      findItemInOrderList(item){
        return _.find(this.orderlist, {'product':item})
      },
      animateAmount(item){
        var index = this.orderlist.indexOf(item);
        $('.cart-list li').eq(index).find('.anim-circle').removeClass('blink');
        setTimeout(function() {
          $('.cart-list li').eq(index).find('.anim-circle').addClass('blink');
        },1);
      },
      placeOrder(){
        setTimeout(function () { 
          this.$http.post('/promomateriaal/order/create', {'orderitems': this.orderlist, 'totalPrice': this.totalPrice }).then((response) => {
            if(response){
              this.$emit('actionSuccess', this.$root.trans.translate('Uw bestelling werd succesvol geplaatst!'));
            }else{
              this.$emit('actionFailed', this.$root.trans.translate('Er is iets foutgelopen bij het plaatsen van uw bestelling, probeer het later opnieuw!'));
            }
          });
        }.bind(this), 1000);

      }
    }
  }
</script>
