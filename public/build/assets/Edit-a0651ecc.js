import{C}from"./Carbon-053ffa43.js";import{P as D}from"./Plan-b784bdd2.js";import{_ as p}from"./InputForm-a774d690.js";import{_ as k}from"./SelectForm-29f4818e.js";import{_ as B}from"./FormSection-28c5426d.js";import{_ as F}from"./PrimaryButton-275c7df4.js";import{_ as N}from"./SecondaryButton-f81cfa04.js";import{_ as z}from"./AppLayout-0cb1b585.js";import{w as E,c as L}from"./helpers-8795bc98.js";import{t as T}from"./toast-44a1761e.js";import{h as g,T as q,j as h,o as r,b as $,w as s,a as n,d as l,f as b,c as d,t as u,u as o,F as f,k as P,e as A,n as O,O as j}from"./app-255317fc.js";import{p as G}from"./periodLabel-28cc2bc8.js";import{_ as S}from"./Checkbox-86ab800b.js";import"./_plugin-vue_export-helper-c27b6911.js";const I=n("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Plan ",-1),Y={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},H=n("div",null," El plan se encuentra activo, por lo que se asume un pago adelantado. ",-1),J={key:1},K=["value"],M=n("option",{value:"",disabled:"",selected:""},"Select a option",-1),Q=["value"],R={class:"block col-span-4"},W={class:"col-span-4 text-lg font-medium text-gray-900"},ce={__name:"Edit",props:{services:{type:Object,required:!1},plan:{type:Boolean,default:!0},isCurrentActive:{type:Boolean,required:!0}},setup(m){const i=m,v=g([]),c=g(!1),e=q(new D(i.plan,i.services[0].id,i.isCurrentActive));let _=null;const U=[{name:"Dashboard",route:"dashboard.index"},{name:"Planes",route:"dashboard.plans.index"},{name:"Actualizar",route:"dashboard.plans.edit",params:[e.plan_id]}],y=h(()=>L({period:e.period,discount:e.discount},v.value)),x=h(()=>(i.isCurrentActive||c.value?_=e.end_date:_=e.start_date,new C(_).addPeriod(parseInt(e.period)).addDays(i.isCurrentActive||c.value?0:-1).format("Y-m-d")));E(e,i.services,v);function w(){e.price=y.value,e.end_date=x.value,e.put(route("dashboard.plans.update",e.plan_id),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{T.success("Plan created successfully!"),j.get(route("dashboard.customers.index"))}})}return(V,a)=>(r(),$(z,{title:"Customer",breads:U},{header:s(()=>[I]),default:s(()=>[n("div",Y,[l(B,{onSubmitted:w},{title:s(()=>[b(" Informacion del plan ")]),description:s(()=>[m.isCurrentActive?(r(),d(f,{key:0},[H,n("div",null," La fecha de fin del plan se actualizara en funcion de la fecha anterior: "+u(o(C).create(m.plan.end_date).format("d/m/Y"))+" y el periodo seleccionado: "+u(o(e).period)+" dias. ",1)],64)):(r(),d("div",J," Actualizar los datos del plan para el cliente. "))]),form:s(()=>[l(k,{modelValue:o(e).service_id,"onUpdate:modelValue":a[0]||(a[0]=t=>o(e).service_id=t),text:"Service",name:"service_id"},{default:s(()=>[(r(!0),d(f,null,P(m.services,t=>(r(),d("option",{value:t.id},u(t.name),9,K))),256))]),_:1},8,["modelValue"]),l(k,{modelValue:o(e).period,"onUpdate:modelValue":a[1]||(a[1]=t=>o(e).period=t),text:"Period"},{default:s(()=>[M,(r(!0),d(f,null,P(v.value,t=>(r(),d("option",{value:t.period},u(o(G)[t.period])+" - "+u(t.value)+" C$ ",9,Q))),256))]),_:1},8,["modelValue"]),m.isCurrentActive?A("",!0):(r(),d(f,{key:0},[l(S,{checked:c.value,"onUpdate:checked":a[2]||(a[2]=t=>c.value=t),text:"Continuar el plan anterior",class:"col-span-4"},null,8,["checked"]),c.value?A("",!0):(r(),$(p,{key:0,text:"Start Date",modelValue:o(e).start_date,"onUpdate:modelValue":a[3]||(a[3]=t=>o(e).start_date=t),type:"date"},null,8,["modelValue"]))],64)),l(p,{text:"End Date",modelValue:x.value,"onUpdate:modelValue":a[4]||(a[4]=t=>x.value=t),type:"date",disabled:""},null,8,["modelValue"]),l(p,{text:"Discount",modelValue:o(e).discount,"onUpdate:modelValue":a[5]||(a[5]=t=>o(e).discount=t),type:"number"},null,8,["modelValue"]),l(p,{text:"Note",modelValue:o(e).note,"onUpdate:modelValue":a[6]||(a[6]=t=>o(e).note=t)},null,8,["modelValue"]),n("div",R,[l(S,{checked:o(e).save_note,"onUpdate:checked":a[7]||(a[7]=t=>o(e).save_note=t),text:"Guardar en notas"},null,8,["checked"])]),n("div",W," Total: C$ "+u(y.value),1)]),actions:s(()=>[l(N,{onClick:a[8]||(a[8]=t=>V.$inertia.visit(V.$page.props.urlPrev))},{default:s(()=>[b(" Cancelar ")]),_:1}),l(F,{class:O({"opacity-25":o(e).processing}),disabled:o(e).processing},{default:s(()=>[b(" Guardar ")]),_:1},8,["class","disabled"])]),_:1})])]),_:1}))}};export{ce as default};
