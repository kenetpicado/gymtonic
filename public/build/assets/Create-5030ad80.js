import{_ as v}from"./AppLayout-69e75404.js";import{_ as b}from"./FormSection-5db579e6.js";import{_ as l}from"./InputForm-4cad8d49.js";import{_ as g}from"./PrimaryButton-ee68edb4.js";import{_ as C}from"./SecondaryButton-79b2464c.js";import{T as $,p as q,o as d,f,w as n,a as y,b as s,d as r,t as u,u as a,c as V,k as N,F as k,h as U,n as B,O as S}from"./app-5a04f978.js";import{_ as w}from"./SelectForm-a8aa7372.js";import"./_plugin-vue_export-helper-c27b6911.js";const D={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},I=["value"],O={class:"text-lg font-medium text-gray-900"},A={__name:"Create",props:{concepts:{type:Object,required:!0},type:{type:String,required:!0}},setup(i){const m=i,e=$({id:null,quantity:1,value:0,discount:0,concept:"",description:"",model_id:""}),p={incomes:"Ingreso",expenditures:"Egreso"},x=q(()=>isNaN(e.value)||isNaN(e.quantity)?0:e.value*e.quantity-e.discount);function _(){e.post(route(`dashboard.${m.type}.store`),{onSuccess:()=>{S.visit(route("dashboard.finances.index",m.type))}})}return(c,o)=>(d(),f(v,{title:"Customer"},{default:n(()=>[y("div",D,[s(b,{onSubmitted:_},{title:n(()=>[r(" Informacion del "+u(p[i.type]),1)]),description:n(()=>[r(" Ingrese los datos del nuevo "+u(p[i.type]),1)]),form:n(()=>[s(w,{text:"Concepto",modelValue:a(e).model_id,"onUpdate:modelValue":o[0]||(o[0]=t=>a(e).model_id=t),name:"model_id",required:""},{default:n(()=>[(d(!0),V(k,null,N(i.concepts,t=>(d(),V("option",{value:t.id},u(t.name),9,I))),256))]),_:1},8,["modelValue"]),s(l,{text:"Descripcion (opcional)",name:"description",modelValue:a(e).description,"onUpdate:modelValue":o[1]||(o[1]=t=>a(e).description=t),autocomplete:"on"},null,8,["modelValue"]),s(l,{text:"Cantidad",name:"quantity",modelValue:a(e).quantity,"onUpdate:modelValue":o[2]||(o[2]=t=>a(e).quantity=t),type:"number"},null,8,["modelValue"]),s(l,{text:"Monto",name:"value",modelValue:a(e).value,"onUpdate:modelValue":o[3]||(o[3]=t=>a(e).value=t),type:"number"},null,8,["modelValue"]),i.type=="incomes"?(d(),f(l,{key:0,text:"Descuento",name:"discount",modelValue:a(e).discount,"onUpdate:modelValue":o[4]||(o[4]=t=>a(e).discount=t),type:"number"},null,8,["modelValue"])):U("",!0),y("div",O," Total: C$ "+u(x.value),1)]),actions:n(()=>[s(C,{onClick:o[5]||(o[5]=t=>c.$inertia.visit(c.route("dashboard.incomes.index")))},{default:n(()=>[r(" Cancelar ")]),_:1}),s(g,{class:B({"opacity-25":a(e).processing}),disabled:a(e).processing},{default:n(()=>[r(" Guardar ")]),_:1},8,["class","disabled"])]),_:1})])]),_:1}))}};export{A as default};
