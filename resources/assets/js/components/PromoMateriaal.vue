<template>
<div>
<hero title="Promomateriaal" :hasSubtitle="true" subtitle="Bestel hier uw promomateriaal" type="is-blue"></hero>

<div class="container mb-50">    

  <modal 
    v-if="showConfirmationModal" 
    @close="showConfirmationModal = false"
    @modalconfirmed="placeOrder"
    :hasYesNoOptions="true"
    >
  </modal>

  <!-- <alert v-if="showAlert" @close="showAlert = false">
    Klik bij een product op 'toevoegen' om deze aan uw bestelling toe te voegen. 
    Bent u klaar? Klik dan op 'Bestelling plaatsen' om de bestelling vast te leggen.
  </alert> -->

  <info-panel :orderPrice="totalPrice"></info-panel>

      <section class="section">
          <table class="table" v-if="orderlist.length > 0">
            <thead>
              <tr>
                <th>Product</th>
                <th>Aantal / pack</th>
                <th>Prijs / pack</th>
                <th>Aantal</th>
                <th>In stock</th>
                <th>Totaal</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            
            <tbody>
              <tr v-for="item in orderlist">
                <td>{{ item.product.name }}</td>
                <td>{{ item.product.pack }}</td>
                <td>{{ '€' + (item.product.price / 100).toFixed(2) }}</td>
                <td><strong>{{ item.amount }}</strong></td>
                <td>{{ item.stock }}</td>
                <td>{{ '€' + calculateTotalPriceForItemInOrder(item).toFixed(2) }}</td>
                <td>
                  <button class="button is-primary" :disabled="item.amount == 1" @click="decreaseAmount(item)"><span class="icon is-small has-icon"><i class="fa fa-minus"></i></span></button>
                  <button class="button is-primary" :disabled="item.stock <= 0" @click="addItemToOrder(item.product)"><span class="icon is-small has-icon"><i class="fa fa-plus"></i></span></button>
                </td>
                <td>
                  <button class="button is-danger" @click="removeItemFromOrder(item)">
                    <span class="icon is-small has-icon">
                      <i class="fa fa-remove"></i>
                    </span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="content">
            <blockquote v-if="orderlist.length < 1" class="has-2m-lineheight">
              <strong>Uw winkelmandje is leeg</strong>
            </blockquote>
            <blockquote v-else class="has-2m-lineheight">
              Totaalprijs: <strong>€ {{ totalPrice.toFixed(2) }}</strong>
              <span><button class="button is-primary pull-right" @click="showConfirmationModal = true">Bestelling plaatsen</button></span>
            </blockquote>
          </div>
      </section>

      <div class="products container-fluid">

          <div class="card product-card" v-for="item in promomateriaal">
            <div class="card-image">
              <figure class="image is-4by4">
                <img :src="'/images/promomateriaal/shoppertas.png'" alt="">
              </figure>
            </div>
            
              <div class="card-content">
                <div class="content">
                  {{ item.name }} per {{ item.pack }} stuks.
                </div>
              </div>

              <footer class="card-footer">
                <a v-if="item.stock > 0" class="card-footer-item is-primary" @click="addItemToOrder(item)">Toevoegen</a>
                <span v-else class="card-footer-item is-red">Out of stock</span>
                <span class="card-footer-item">{{ item.stock }} in stock</span>
                <span class="card-footer-item">{{ '€' + (item.price / 100).toFixed(2) }}</span>
              </footer>

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
                this.$http.get('/promomateriaal/get').then((response) => {
                    this.promomateriaal = response.body;
                });
            },
            addItemToOrder(item){
              if(this.checkBudget(item)){
                var ordereditem = this.findItemInOrderList(item);
                if(!ordereditem){
                  var stock = item.stock;
                  this.orderlist.push({'product': item, 'amount': 1, 'stock': stock-1});
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
            },
            increaseAmount(item){
              if(item.stock > 0){
                item.amount++;
                item.stock--;
              }
              this.calculateTotalPriceForOrder();
            },
            decreaseAmount(item){
              if(item.amount > 1){
                item.amount--;
                item.stock++;
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
            placeOrder(){
              setTimeout(function () { 
                this.$http.post('/promomateriaal/order/create', {'orderitems': this.orderlist, 'totalPrice': this.totalPrice }).then((response) => {
                  if(response){
                    this.$emit('actionSuccess', "Uw bestelling werd successvol geplaatst!");
                  }else{
                    this.$emit('actionFailed', "Er is iets foutgelopen bij het plaatsen van uw bestelling, probeer het later opnieuw!");
                  }
                });
               }.bind(this), 1000);
              
            }
        }
    }
</script>
