<template>
    <v-container grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12>
                <h1>Clinic Name</h1>
            </v-flex>
            <v-flex xs12 class="address">
                <h4 >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, animi aspernatur distinctio
                    dolorem ducimus enim eum facere fuga inventore iusto magni odio porro possimus quaerat quia
                    repudiandae rerum, ut. Nulla.
                </h4>
            </v-flex>
            <v-flex xs12 class="headline">
                <h3 >Lab Test Receipt</h3>
            </v-flex>
            <v-flex xs6 class="head_tab">
                <table >
                    <thead>
                    <tr>
                        <th style="border: none">ID: {{inv_dtl.inv_id}}</th>
                    </tr>
                    <tr>
                        <th style="border: none">Name: {{inv_dtl.name}}</th>
                    </tr>
                    <tr>
                        <th style="border: none">Refd. By: {{inv_dtl.refd_by}}</th>
                    </tr>
                    </thead>
                </table>
            </v-flex>
            <v-flex xs6 class="head_tab">
                <table>
                    <thead>
                    <tr>
                        <th class="blank">Date: {{inv_dtl.date}}</th>
                    </tr>
                    <tr>
                        <th class="blank">Age: {{inv_dtl.age}}</th>
                    </tr>
                    <tr>
                        <th class="blank">Mobile: {{inv_dtl.mobile_no}}</th>
                    </tr>
                    </thead>
                </table>
            </v-flex>
            <v-flex id="main_tab" xs12>
                <table >
                    <thead>
                    <tr>
                        <th class="back_clolor">SL</th>
                        <th class="back_clolor">Name</th>
                        <th class="back_clolor">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(dtl,index) in inv_dtl.all_test">
                        <td>{{index+1}}</td>
                        <td>{{dtl.name}}</td>
                        <td>{{dtl.price}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Total: {{inv_dtl.grand_total}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Cash: {{inv_dtl.cash}}
                        </td>
                    </tr>
                    <tr v-if="inv_dtl.discount>0">
                        <td colspan="2" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Discount: {{inv_dtl.discount}}%
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Due: {{inv_dtl.grand_total-inv_dtl.cash}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </v-flex>
            <v-flex xs6 class="head_tab">
                <table >
                    <thead>
                    <tr>
                        <th style="border: none">Prepared By: {{inv_dtl.added_by}}</th>
                    </tr>
                    <tr>
                        <th style="border: none">Office Copy</th>
                    </tr>
                    </thead>
                </table>
            </v-flex>
        </v-layout>
        <v-spacer></v-spacer>
        <hr style="margin-top:20px">
        <v-layout row wrap>
            <v-flex xs12>
                <h1>Clinic Name</h1>
            </v-flex>
            <v-flex xs12 class="address">
                <h4 >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, animi aspernatur distinctio
                    dolorem ducimus enim eum facere fuga inventore iusto magni odio porro possimus quaerat quia
                    repudiandae rerum, ut. Nulla.
                </h4>
            </v-flex>
            <v-flex xs12 class="headline">
                <h3 >Lab Test Receipt</h3>
            </v-flex>
            <v-flex xs6 class="head_tab">
                <table >
                    <thead>
                    <tr>
                        <th style="border: none">ID: {{inv_dtl.inv_id}}</th>
                    </tr>
                    <tr>
                        <th style="border: none">Name: {{inv_dtl.name}}</th>
                    </tr>
                    <tr>
                        <th style="border: none">Refd. By: {{inv_dtl.refd_by}}</th>
                    </tr>
                    </thead>
                </table>
            </v-flex>
            <v-flex xs6 class="head_tab">
                <table>
                    <thead>
                    <tr>
                        <th class="blank">Date: {{inv_dtl.date}}</th>
                    </tr>
                    <tr>
                        <th class="blank">Age: {{inv_dtl.age}}</th>
                    </tr>
                    <tr>
                        <th class="blank">Mobile: {{inv_dtl.mobile_no}}</th>
                    </tr>
                    </thead>
                </table>
            </v-flex>
            <v-flex id="main_tab" xs12>
                <table >
                    <thead>
                    <tr>
                        <th class="back_clolor">SL</th>
                        <th class="back_clolor">Name</th>
                        <th class="back_clolor">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(dtl,index) in inv_dtl.all_test">
                        <td>{{index+1}}</td>
                        <td>{{dtl.name}}</td>
                        <td>{{dtl.price}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Total: {{inv_dtl.grand_total}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Cash: {{inv_dtl.cash}}
                        </td>
                    </tr>
                    <tr v-if="inv_dtl.discount>0">
                        <td colspan="2" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Discount: {{inv_dtl.discount}}%
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Due: {{inv_dtl.grand_total-inv_dtl.cash}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </v-flex>
            <v-flex xs6 class="head_tab">
                <table >
                    <thead>
                    <tr>
                        <th style="border: none">Prepared By: {{inv_dtl.added_by}}</th>
                    </tr>
                    <tr>
                        <th style="border: none">Office Copy</th>
                    </tr>
                    </thead>
                </table>
            </v-flex>
        </v-layout>

    </v-container>
</template>

<script>
    export default {
        name: "pathology_receipt",

        mounted(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/lab/patient/invoice/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.inv_dtl=res;
                    })
            }
        },
        data(){
            return{
                inv_dtl:{
                    added_by: "Munna Khan",
                    inv_id: 1,
                    age: "45",
                    cash: "220",
                    date: "2018-10-31 10:51 AM",
                    grand_total: "2250",
                    mobile_no: "01788963665",
                    name: "Abul",
                    refd_by: "doctor mbbs",
                    discount:0,
                    all_test:null,
                }
            }
        }
    }
</script>

<style scoped>
    @page {
        size: A4;
        margin: 0;
    }

    .head_tab>table, th, td {
        border-collapse: collapse;
        text-align: justify;
    }
    .head_tab>table {
        width: 100%;
    }
    .address{
        text-align: center;
    }
    .headline{
        background-color: darkgrey;
        font-size:20px
    }
    #main_tab>table,th,td{
        border: solid 1px black;
        border-collapse: collapse;
        padding: 5px;
    }
    #main_tab>table{
        width: 100%;
    }
    .blank{
        border: 0;
    }

    .back_clolor{
        background-color: darkgrey
    }
</style>



