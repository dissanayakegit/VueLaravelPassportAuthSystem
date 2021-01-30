<template>
    <div class="container main">
        <button type="button" class="btn btn-primary common-margit-bottom" @click.prevent="openModal(false, null)">
            {{ ("Add new customer") }}
        </button>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">{{ ("Name") }}</th>
                <th scope="col">{{ ("Address") }}</th>
                <th scope="col">{{ ("Email") }}</th>
                <th scope="col">{{ ("Contact") }}</th>
                <th scope="col">{{ ("Edit") }}</th>
                <th scope="col">{{ ("Delete") }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="customer in customers">
                <td>{{ customer.name }}</td>
                <td>{{ customer.address }}</td>
                <td>{{ customer.email }}</td>
                <td>{{ customer.phone_number }}</td>
                <td>
                    <button type="button" class="btn btn-warning"
                            @click.prevent="openModal(true,customer)">
                        <i class="bi bi-pencil"></i>
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger"
                            @click="deleteCustomer(customer.id)">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>


        <!-- Modal -->
        <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" @click.prevent="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name">{{ ("Name:") }}</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name"
                                       v-model="customerName">
                                <span class="text-danger" v-if="errors.customerName">{{ errors.customerName[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ ("Address:") }}</label>
                                <input type="text" class="form-control" id="address" placeholder="Enter address"
                                       v-model="customerAddress">
                                <span class="text-danger"
                                      v-if="errors.customerAddress">{{ errors.customerAddress[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ ("Email:") }}</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email"
                                       v-model="customerEmail">
                                <span class="text-danger"
                                      v-if="errors.customerEmail">{{ errors.customerEmail[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ ("Contact Number:") }}</label>
                                <input type="text" class="form-control" id="phone"
                                       placeholder="Enter contact number" v-model="customerContactNumber">
                                <span class="text-danger"
                                      v-if="errors.customerContactNumber">{{ errors.customerContactNumber[0] }}</span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click.prevent="closeModal">{{
                                ("Close")
                            }}
                        </button>
                        <button type="button" class="btn btn-primary" @click.prevent="submit()">{{ ("Save") }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            customerName: '',
            customerAddress: '',
            customerEmail: '',
            customerContactNumber: '',
            customers: [],
            isNewRecord: true,
            customerId: null,
            errors: {}
        }
    },
    mounted() {
        this.getAllCustomers();
    },
    methods: {
        openModal(isEdit = false, customer) {
            this.customerContactNumber = '';
            this.customerEmail = '';
            this.customerAddress = '';
            this.customerName = '';
            if (isEdit === true && customer !== null) {
                this.isNewRecord = false;
                this.editCustomer(customer)
            }
            $("#customerModal").modal('show');
        },

        closeModal() {
            this.errors = {};
            $("#customerModal").modal('hide');
        },

        submit() {
            let url = '';
            let saveData = {
                customerName: this.customerName,
                customerAddress: this.customerAddress,
                customerEmail: this.customerEmail,
                customerContactNumber: this.customerContactNumber
            };
            if (this.isNewRecord == true) {
                url = 'add-new-customer'
            } else {
                url = 'update-customer/' + this.customerId
            }
            axios.post(url, saveData).then(response => {
                if (response.data.data && !response.data.data.errors) {
                    this.$swal({
                        title: 'Succeed',
                        text: "Customer created successfully",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closeModal();
                            this.getAllCustomers();
                        }
                    })
                } else {
                    this.errors = response.data.data.errors.validations;
                }
            });
        },

        getAllCustomers() {
            axios.get('get-all-customers').then(response => {
                if (response.data) {
                    this.customers = response.data;
                }
            });
        },

        editCustomer(customer) {
            this.customerId = customer.id;
            this.customerName = customer.name;
            this.customerAddress = customer.address;
            this.customerEmail = customer.email;
            this.customerContactNumber = customer.phone_number
        },

        deleteCustomer(cusId) {
            this.$swal({
                title: 'Are you sure?',
                text: "customer is going to be deleted permanently",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('delete-customer/' + cusId).then(response => {
                        if (response.data) {
                            this.$swal({
                                title: 'Succeed',
                                text: "Customer deleted successfully",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            });
                            this.getAllCustomers();
                        }
                    });
                }
            });
        },
    }
}
</script>
