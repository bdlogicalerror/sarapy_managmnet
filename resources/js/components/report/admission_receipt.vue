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
                <h3 >Admission Receipt</h3>
            </v-flex>
            <v-flex xs4 class="head_tab">
                <table >
                    <thead>
                    <tr>
                        <th style="border: none">Admission ID: {{inv_dtl.admission_id}}</th>
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
            <v-flex xs4 class="head_tab">
                <table>
                    <thead>
                    <tr>
                        <th class="blank">Admission Date: <span style="font-size: 12px">{{inv_dtl.date}}</span></th>
                    </tr>
                    <tr>
                        <th class="blank">Age: {{inv_dtl.age}}</th>
                    </tr>
                    <tr>
                        <th v-if="inv_dtl.resident_type=='Cabin'" class="blank">Cabin: {{inv_dtl.cabin_no}}</th>
                        <th v-else class="blank">Ward: {{inv_dtl.ward_no}}</th>
                    </tr>
                    </thead>
                </table>
            </v-flex>
            <v-flex xs4 class="head_tab">
                <table>
                    <thead>
                    <tr>
                        <th class="blank">Patient ID: {{inv_dtl.patient_id}}</th>
                    </tr>
                    <tr>
                        <th class="blank">Mobile: {{inv_dtl.mobile_no}}</th>
                    </tr>
                    <tr>
                        <th class="blank">Bed No: {{inv_dtl.bed_no}}</th>
                    </tr>
                    </thead>
                </table>
            </v-flex>
            <v-flex xs4 class="head_tab">
                <table>
                    <thead>
                    <tr>
                        <th style="border: none;font-weight:bold;color: red">{{inv_dtl.status}}</th>
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
                        <th class="back_clolor">Date</th>
                        <th class="back_clolor">Amount</th>
                        <th class="back_clolor">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(service,index) in inv_dtl.services">
                        <td>{{index+1}}</td>
                        <td>{{service.name}}</td>
                        <td>{{service.date}}</td>
                        <td>{{service.amount}}</td>
                        <td>{{service.total}}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Total: {{inv_dtl.grand_total}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="blank">

                        </td>
                        <td  style="text-align:left;padding-left:10px">
                            Cash: {{inv_dtl.cash}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="blank">

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
                        <th style="border: none">Invoice Created at: {{inv_dtl.created_at}}</th>
                    </tr>

                    </thead>
                </table>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        name: "admission_receipt",

        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/admission/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.inv_dtl=res;
                    })
            }
        },
        data(){
            return{
                inv_dtl:{
                    status:"",
                    created_at:"",
                    added_by: "Munna Khan",
                    admission_id: 1,
                    age: "45",
                    bed_no: null,
                    services:[],
                    cabin_no: 22,
                    cash: "220",
                    date: "2018-10-31 10:51 AM",
                    grand_total: "2250",
                    mobile_no: "01788963665",
                    name: "Abul",
                    patient_id: 1,
                    refd_by: "doctor mbbs",
                    resident_type: "Cabin",
                    ward_no: null,
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
