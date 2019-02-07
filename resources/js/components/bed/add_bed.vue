<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>Add Bed</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'all_beds'}">
                <v-icon>keyboard_backspace</v-icon>
            </v-btn>
        </v-toolbar>

        <v-flex xs12>
            <v-card color="blue-grey darken-2" class="white--text">
                <v-card-title >

                </v-card-title>
                <v-container
                        fill-height
                        fluid
                        pa-2
                >
                    <v-layout fill-height>
                        <v-flex xs12 align-end flexbox>
                            <v-form v-model="valid">
                                <v-text-field
                                        v-model="bed.no"
                                        :rules="required_rules"
                                        :counter="10"
                                        label="bed No"
                                        required
                                        solo-inverted

                                        class="mx-3"
                                ></v-text-field>


                                <v-autocomplete
                                        v-model="bed.ward_no"
                                        :items="wards"
                                        :filter="customFilter"
                                        color="white"
                                        item-text="ward_name"
                                        item-value="id"
                                        label="Ward Name"
                                        solo-inverted
                                        class="mx-3"
                                        :rules="required_rules"
                                        required
                                ></v-autocomplete>


                                <v-text-field
                                        v-model="bed.bed_rent"
                                        :rules="required_rules"
                                        :counter="10"
                                        label="Bed Rent"
                                        required
                                        solo-inverted
                                        class="mx-3"
                                ></v-text-field>


                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_bed" color="primary">Add</v-btn>
                    <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_bed">Update</v-btn>
                    <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_bed" color="error">Delete</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "add_bed",
        data: () => ({

            //---------------------------
             hasSaved: false,
             model: null,
             wards: [

             ],
            //------------


            valid: false,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            bed:{
                id:"",
                no:"",
                bed_rent:'',
                ward_no:"",
                delete:false,
            },




        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/resident/bed/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.bed.id=res.id;
                        this.bed.no=res.bed_no;
                        this.bed.bed_rent=res.bed_rent;
                        this.bed.ward_no=res.ward_no;
                    });
                this.edit = true;

            }
            axios.get('/gotisoft/resident/ward/search/all')
                .then(res => {
                    this.wards=res.data;
                })

        },
        methods:{
            add_bed(){
                this.$Progress.start();
                axios.post('/gotisoft/resident/bed/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.bed
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$router.push('/resident/beds');
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.bed.no=0;
                        this.bed.rent=0;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_bed(){
                this.bed.delete=true;
                this.update_bed();
            },
            update_bed(){
                this.$Progress.start();
                axios.put('/gotisoft/resident/bed/'+this.bed.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.bed
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type=='error'?'Deleted':res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.bed.no=0;
                        this.bed.rent=0;
                        this.$router.push('/resident/beds')

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },

            customFilter (item, queryText, itemText) {
                console.log(queryText)



                const textOne = item.name.toLowerCase()
                const textTwo = item.abbr.toLowerCase()
                const searchText = queryText.toLowerCase()

                return textOne.indexOf(searchText) > -1 ||
                    textTwo.indexOf(searchText) > -1
            },
        }
    }
</script>

<style scoped>

</style>
