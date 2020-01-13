/* global axios, Swal */

const app = new Vue({
    el: '#app',
    data() {
        return {
            orderData: false,
            orders: []
        };
    },
    mounted: function () {
        this.getOrders();
    },
    methods: {
        getOrders() {
            axios.get('/get-orders')
                    .then(response => {
                        this.orders = response.data;
                    }).catch(error => {
                console.log(error);
            }).finally(() => this.orderData = true);
        },
        deliveredOrder(orderIndex) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You have deliveredt this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delivered!'
            }).then((result) => {
                if (result.value) {
                    let order = this.orders[orderIndex];
                    let dataForm = new FormData();
                    dataForm.append('order_id', order.id);
                    axios.post('/order-delivered', dataForm)
                            .then(response => {
                                let result = response.data;
                                if (result.status === 2) {
                                    if (orderIndex > -1) {
                                        this.orders.splice(orderIndex, 1);
                                    }
                                    this.showSuccessMessage('Order Delevered');
                                }
                            }).catch(error => {
                        console.log(error);
                    });
                }
            });
        },

        showSuccessMessage(message) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        },
        showErrorMessage(message) {
            Swal.fire({
                icon: 'error',
                title: 'Sorry!',
                text: message
            });
        }
    }
});