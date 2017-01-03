<template>
	<div>
		<hero title="Kantoormateriaal" :hasSubtitle="true" subtitle="Bestel hier uw kantoormateriaal" type="is-blue"></hero>
		<div class="container mb-50">
			<modal 
				v-if="showConfirmationModal" 
				@close="showConfirmationModal = false"
				@modalconfirmed="placeOrder"
				:hasYesNoOptions="true"
				>
			</modal>

			<info-panel :noBudget="true"></info-panel>

	<section class="section">
          <table class="table" v-if="orderlist.length > 0">
            <thead>
              <tr>
                <th>Product</th>
                <th>Aantal / pack</th>
                <th>Aantal</th>
                <th>In stock</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            
            <tbody>
              <tr v-for="item in orderlist">
                <td>{{ item.product.name }}</td>
                <td>{{ item.product.pack }}</td>
                <td><strong>{{ item.amount }}</strong></td>
                <td>{{ item.stock }}</td>
                <td>
                  <button class="button is-primary" :disabled="item.amount == 1" @click="decreaseAmount(item)"><span class="icon is-small has-icon"><i class="fa fa-minus"></i></span></button>
                  <button class="button is-primary" :disabled="item.stock <= 0" @click="increaseAmount(item)"><span class="icon is-small has-icon"><i class="fa fa-plus"></i></span></button>
                </td>
                <td>
                  <a class="button is-danger transitioning-icon" @click="removeItemFromOrder(item)">
                    <span class="icon is-small has-stacked-icons has-animation">
                      <i class="fa fa-remove"></i>
                      <i class="fa fa-trash"></i>
                    </span>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="content">
            <blockquote v-if="orderlist.length < 1" class="has-2m-lineheight">
              <strong>Uw winkelmandje is leeg</strong>
            </blockquote>
            <blockquote v-else class="has-2m-lineheight">
            Totaalprijs: <strong>Deze producten zijn gratis</strong>
              <span><button class="button is-primary pull-right" @click="showConfirmationModal = true">Bestelling plaatsen</button></span>
            </blockquote>
          </div>
      </section>

      <div class="products container-fluid">

          <div class="card product-card" v-for="item in kantoormateriaal">
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
                <span class="card-footer-item">Gratis</span>
              </footer>

            </div>
        </div>
      <div class="is-clearfix"></div>
  </div>

	</div>
	
</template>

<script>
	export default{
		mounted(){
			this.fetchItemsInStock();
		},
		data(){
			return{
				orderlist: [],
				kantoormateriaal: [],
				showAlert: true,
                showConfirmationModal: false
			}
		},
		methods:{
			fetchItemsInStock(){
                this.$http.get('/kantoormateriaal/get').then((response) => {
                    this.kantoormateriaal = response.body;
                });
            },
            addItemToOrder(item){
                var ordereditem = this.findItemInOrderList(item);
                if(!ordereditem){
                  var stock = item.stock;
                  this.orderlist.push({'product': item, 'amount': 1, 'stock': stock-1});
                }else{
                  this.increaseAmount(ordereditem);
                }
            },
            removeItemFromOrder(item){
              this.orderlist.splice(this.orderlist.indexOf(item), 1);
            },
            increaseAmount(item){
              if(item.stock > 0){
                item.amount++;
                item.stock--;
              }
            },
            decreaseAmount(item){
              if(item.amount > 1){
                item.amount--;
                item.stock++;
              }
            },
            findItemInOrderList(item){
              return _.find(this.orderlist, {'product':item})
            },
            placeOrder(){
              console.log("placing order");
              setTimeout(function () { 
                this.$http.post('/kantoormateriaal/order/create', {'orderitems': this.orderlist }).then((response) => {
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