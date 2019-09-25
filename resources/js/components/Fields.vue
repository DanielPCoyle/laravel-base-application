<template>
    <div>
        <b-row>
            <template v-for="item,key in preparedFields">
                <input type='hidden' 
                name='id'  
                v-if='item.key == "id"' 
                v-model="values[item.key]"
                :ref="item.key"
                :class="item.key">

                <transition v-else name="fade">
                    <b-form-group 
                    v-show='(requiredOnly == false || item.required == true) && item.type !== "hidden"'
                    :key='key'
                    :id="'input-group-'+key"
                    :label="item.label"
                    :label-for="'input-'+key"
                    :class='formClass(item)'
                    :description="item.form_description"
                    >

                    <!--DEFAULT INPUTS-->
                    <template v-if='defaultInputs.indexOf(item.type) >= 0'>
                        <b-form-input :id="'input-'+key" v-model="values[item.key]"
                        :ref="item.key"
                        :class="item.key" 
                        :type='item.type'  
                        :placeholder="item.placeholder" 
                        :required='item.required'
                        :disabled='item.disabled'
                        :size="item.size"
                        :state="item.state"
                        :autofocus="item.autofocus"
                        :number='item.number'
                        :plaintext='item.plaintext'
                        :readonly="item.readonly"
                        :autocomplete="item.autocomplete"
                        :trim="item.trim"
                        :list="item.list"
                        :max="item.max"
                        :min="item.min"
                        :step="item.step">
                    </b-form-input>
                </template>

                <template v-if='item.type == "text-repeater"'>
                    <div v-if='values[item.key] && values[item.key].length == 0'>
                          <b-input-group class="mt-3">
                            <b-form-input size="sm"  v-model="values[item.key][0]"></b-form-input>
                            <b-input-group-append>
                              <b-button  size="sm" @click="addRepeater(item.key)" variant="outline-success">+</b-button>
                              <b-button  size="sm" @click="removeRepeater(item.key,index)" variant="outline-danger">-</b-button>
                            </b-input-group-append>
                          </b-input-group>
                    </div>
                    <div else v-for="find,index in values[item.key]">
                        <b-input-group class="mt-3">
                        <b-form-input size="sm" v-model="values[item.key][index]"></b-form-input>
                        <b-input-group-append>
                          <b-button size="sm" variant="outline-success"  @click="addRepeater(item.key)">+</b-button>
                          <b-button size="sm" variant="outline-danger" @click="removeRepeater(item.key,index)">-</b-button>
                        </b-input-group-append>
                      </b-input-group>
                      </div>
                </template>

                <!--SELECT INPUT-->
            <template v-if='item.type == "select"'>
                    <b-form-select 
                    v-model="values[item.key]"
                    :ref="item.key"
                    :class="item.key"
                    :options="item.options" 
                    :required='item.required'
                    :disabled='item.disabled'
                    size="sm"
                    :state="item.state"
                    :plain="item.plain"
                    :autofocus="item.autofocus">
                </b-form-select>
            </template>                <!--SELECT INPUT-->

            <template v-if='item.type == "select-repeater"'>
            <b-row v-if='values[item.key] && values[item.key].length == 0'>
                <b-col>
                 <b-form-select 
                    v-model="values[item.key][0]"
                    :ref="item.key"
                    :class="item.key+' mt-2'"
                    :options="item.options" 
                    :required='item.required'
                    :disabled='item.disabled'
                    size="sm"
                    :state="item.state"
                    :plain="item.plain"
                    :autofocus="item.autofocus">
                </b-form-select>
                </b-col>
            </b-row>

            <b-row v-else v-for="find,index in values[item.key]" key='index'>
                <b-col cols='10'>
                 <b-form-select 
                    v-model="values[item.key][index]"
                    :ref="item.key"
                    :class="item.key +' mt-2'"
                    :options="item.options" 
                    :required='item.required'
                    :disabled='item.disabled'
                    size="sm"
                    :state="item.state"
                    :plain="item.plain"
                    :autofocus="item.autofocus">
                </b-form-select>
            </b-col>
            <b-col cols='2'>
                <b-row>
              <b-button size="sm" variant="outline-success"  class='mt-2' @click="addRepeater(item.key)">+</b-button>
              <b-button size="sm" variant="outline-danger" class='mt-2' @click="removeRepeater(item.key,index)">-</b-button>
                </b-row>
            </b-col>
            </b-row>

            </template>

            <!--Checkbox INPUT -->
            <template v-if='item.type == "checkboxes"'>
                <b-form-checkbox-group 
                :id="'checkbox-group-'+key"
                v-model="values[item.key]"
                :ref="item.key"
                :class="item.key"
                :options="item.options"
                :required='item.required'
                :disabled='item.disabled'
                :size="item.size"
                :state="item.state"
                :plain="item.plain"
                :buttons="item.buttons"
                :stacked="item.stacked"
                :button-variant="item.button_variant"
                :autofocus="item.autofocus"
                :switchs="item.switches"
                :html-field="item.html-field"
                :text-field="item.text-field"
                :validated="item.validated"
                ></b-form-checkbox-group>
            </template>

            <!--BOOLEAN INPUT-->
            <template v-if='item.type == "boolean"'>
                <div>
                    <b-form-checkbox
                    :id="'input-'+key"
                    v-model="values[item.key]"
                    :ref="item.key"
                    :class="item.key"
                    :unchecked-value="item.unchecked_value"
                    :required='item.required'
                    :disabled='item.disabled'
                    :size="item.size"
                    :state="item.state"
                    :plain="item.plain"
                    :button="item.button"
                    :button-variant="item.button_variant"
                    :switch="item.switch"
                    :autofocus="item.autofocus" >
                </b-form-checkbox>
            </div>
        </template>

        <!--Checkbox INPUT-->
        <template v-if='item.type == "checkbox"'>
            <div>
                <b-form-checkbox
                :id="'input-'+key"
                v-model="values[item.key]"
                :ref="item.key"
                :class="item.key"
                :unchecked-value="item.unchecked_value"
                :required='item.required'
                :disabled='item.disabled'
                :size="item.size"
                :state="item.state"
                :plain="item.plain"
                :button="item.button"
                :button-variant="item.button_variant"
                :switch="item.switch"
                :indeterminate="item.indeterminate"
                :inline="item.inline"
                :autofocus="item.autofocus" >
            </b-form-checkbox>
        </div>
    </template>

    <!--RADIO INPUT-->
    <template v-if='item.type == "radio"'>
      <b-form-radio-group :id="'radio-group-'+item.key" stacked v-model="values[item.key]">
        <b-form-radio v-for='option in item.options' :value="option.value">{{option.text}}</b-form-radio>
      </b-form-radio-group>
    </template>

<!--TEXTAREA INPUT-->
<template v-if='item.type == "textarea"'>
    <b-form-textarea
    v-model="values[item.key]"
    :rows="item.rows || 2"
    :ref="item.key"
    :class="item.key"
    :placeholder="item.placeholder"
    :required='item.required'
    :disabled='item.disabled'
    :size="item.size"
    :state="item.state"
    :autofocus="item.autofocus"
    :number='item.number'
    :plaintext='item.plaintext'
    :readonly="item.readonly"
    :autocomplete="item.autocomplete"
    :trim="item.trim"
    :max_rows="item.max_rows"
    :wrap="item.wrap"
    >
</b-form-textarea>
</template>

<!--TEXTAREA INPUT-->
<template v-if='item.type == "html"'>
    <b-row>
        <b-col class='text-right'>
            <a href='#' @click='item.source_view = !item.source_view'>Source View</a>
        </b-col>
    </b-row>
    <b-form-textarea
    v-if='item.source_view == true'
    v-model="values[item.key]"
    :ref="item.key"
    :class="item.key"
    :placeholder="item.placeholder"
    max-rows="6"
    :required='item.required'
    :disabled='item.disabled'
    :size="item.size"
    :state="item.state"
    :autofocus="item.autofocus"
    ></b-form-textarea>
    <vue-editor v-if='item.source_view == false' v-model="values[item.key]"
    :ref="item.key"
    :class="item.key">
</vue-editor>
</template>

<!--MULTISELECT INPUT-->
<template v-if='item.type == "multiselect"'>
    <b-form-select multiple v-model="values[item.key]"
    :ref="item.key"
    :class="item.key"
    :required='item.required'
    :disabled='item.disabled'
    :size="item.size"
    :state="item.state"
    :plain="item.plain"
    :disabled-field="item.disabled-field"
    :html-field="item.html-field"
    :options="item.options"
    :text-field="item.text-field"
    :multiple="item.multiple"
    :select-size="item.select-size"
    :autofocus="item.autofocus"></b-form-select>
</template>

<!--FILE INPUT-->
<template v-if='item.type == "file"'>
    <b-form-file
    v-model="values[item.key]"
    :ref="item.key"
    :class="item.key"
    :placeholder="item.placeholder"
    drop-placeholder="Drop file here..."
    :required='item.required'
    :disabled='item.disabled'
    :size="item.size"
    :state="item.state"
    :autofocus="item.autofocus"
    ></b-form-file>
</template>

<!--YOUTUBE INPUT-->
<template v-if="item.type == 'youtube'">
    <b-form-input @blur.native='youtube(item.key)' :id="'input-'+key" v-model="values[item.key]"
    :ref="item.key"
    :class="item.key" :placeholder="item.placeholder" 
    :required='item.required'
    :disabled='item.disabled'
    :size="item.size"
    :state="item.state"
    :autofocus="item.autofocus">
</b-form-input>

<b-embed
v-if='values[item.key] && values[item.key].includes("youtu")  && values[item.key].includes("http")'
type="iframe"
aspect="16by9"
:src="values[item.key]"
allowfullscreen>    
</b-embed>
</template>

<div v-if='errors[item.key]' class='validationMessage'>{{errors[item.key]}}</div>
</b-form-group>
</transition>
</template>
</b-row>
</div>
</template>
<script>
    import { VueEditor } from "vue2-editor";

    export default {
        name: "fields",
        props:['fields','values'],
        components: {
            VueEditor
        },
        data: function(){
            return {
                defaultInputs: ["text", "password", "email", "number", "url", "tel", "date", "time", "range", "color", 'month', 'week'],
                queriedInputs: [],
                errors:[],
                requiredOnly:false,
            }
        },
        methods:{
            formClass : function(item){
                if(item.class)
                    return item.class
                else
                    return 'col-12'
            },
            youtube : function(key){
                var value = this.$props.values[key];
                if(value.indexOf("youtu") < 0 || value.indexOf("http") < 0){
                    this.$props.values[key] = "";
                    this.errors[key] ="Must be a youtube URL"  
                } else{
                    this.$props.values[key] = value.replace('watch?v=','embed/');
                    delete  this.errors[key] 
                }
            },
            orderedFields: function () {
                // var result = this._.sortBy(this.$props.fields, 'sort');
                return this.$props.fields
            },
            addRepeater: function(key){
                var comp = this;
                comp.$props.values[key].push("");
            },
            removeRepeater:function(key,index){
                var comp = this;
                comp.$props.values[key].splice(index,1);
            },
            getOptions: function (item) {
                var comp = this;
                if(!item.target){
                    return false
                }
                var tag = item.target+"/"+item.key+"/"+comp.$props.values.id;
                    comp.$props.fields[item.key].options = [];
                    comp.axios
                    .get('/api/get-options/'+item.target)
                    .then(function(response){
                        comp.$props.fields[item.key].options = response.data;
                        localStorage.setItem(tag, JSON.stringify(response.data));
                        comp.queriedInputs.push(item.key);
                        comp.orderedFields()
                    });
            },
        },
        computed: {
            preparedFields : function () {
                var preparedFields = this.orderedFields();
                return preparedFields;
            }
        },
        beforeUpdate: function(){
            var comp = this;
            var item
            var updated = [];
            for (var key in comp.$props.fields) {
                if(comp.queriedInputs.indexOf(key) < 0){
                    item = comp.$props.fields[key];
                    comp.getOptions(item);
                    updated.push(key);
                }
            }
        },
    }
</script>
<style>

</style>