import{_ as z}from"./AppLayout-69e75404.js";import{_ as w}from"./FormSection-5db579e6.js";import{j as G,T as O,p as N,o as n,f as T,w as r,a as i,b as s,d as l,u as a,i as j,n as B,c as u,F as b,k as D,t as f,O as P}from"./app-5a04f978.js";import{_ as m}from"./InputForm-4cad8d49.js";import{_ as V}from"./PrimaryButton-ee68edb4.js";import{_ as x}from"./SelectForm-a8aa7372.js";import{_ as F}from"./SecondaryButton-79b2464c.js";import{S as q}from"./SectionBorder-2a8c07bb.js";import{C as L}from"./Carbon-053ffa43.js";import{t as E}from"./toast-0c928852.js";import{w as M,c as H}from"./helpers-70796b54.js";import{P as A}from"./Plan-b784bdd2.js";import{p as J}from"./periodLabel-28cc2bc8.js";import{_ as K}from"./Checkbox-c729acdf.js";import"./_plugin-vue_export-helper-c27b6911.js";const Q={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},R={class:"grid grid-cols-2 gap-6"},W=i("option",{value:"F"},"Femenino",-1),X=i("option",{value:"M"},"Masculino",-1),Y={key:0},Z={key:1},ee=i("span",{class:"block mt-2"},null,-1),te=i("br",null,null,-1),oe={key:1},ae=["value"],se=i("option",{value:"",disabled:"",selected:""},"Select a option",-1),re=["value"],de={class:"block col-span-4"},le={class:"col-span-4 text-lg font-medium text-gray-900"},he={__name:"Create",props:{customer:{type:Object,required:!1},isNew:{type:Boolean,default:!0},services:{type:Object,required:!0}},setup(c){var C,h,k,S,$,U;const d=c,v=G([]),e=O({id:((C=d.customer)==null?void 0:C.id)??null,name:((h=d.customer)==null?void 0:h.name)??"",phone:((k=d.customer)==null?void 0:k.phone)??"",birth_date:((S=d.customer)==null?void 0:S.birth_date)??"",gender:(($=d.customer)==null?void 0:$.gender)??"F",...new A((U=d.customer)==null?void 0:U.plan,d.services[0].id)}),I=[{name:"Inicio",route:"dashboard.index"},{name:"Clientes",route:"dashboard.customers.index"},{name:d.isNew?"Crear":"Editar",route:"dashboard.customers.create"}],g=N(()=>H({period:e.period,discount:e.discount},v.value));M(e,d.services,v);const _=N(()=>L.create(e.start_date).addPeriod(parseInt(e.period)).addDays(-1).format());function y(){e.price=g.value,e.end_date=_.value,d.isNew?e.post(route("dashboard.customers.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{E.success("Cliente creado correctamente!"),P.get(route("dashboard.customers.index"))}}):e.put(route("dashboard.customers.update",e.id),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{E.success("Cliente actualizado correctamente!"),P.get(route("dashboard.customers.index"))}})}return(p,o)=>(n(),T(z,{title:"Customer",breads:I},{default:r(()=>[i("div",Q,[s(w,{onSubmitted:y},{title:r(()=>[l(" Informacion del Cliente ")]),description:r(()=>[l(" Datos personales del cliente ")]),form:r(()=>[i("div",R,[s(m,{text:"Name",modelValue:a(e).name,"onUpdate:modelValue":o[0]||(o[0]=t=>a(e).name=t)},null,8,["modelValue"]),s(m,{text:"Phone",modelValue:a(e).phone,"onUpdate:modelValue":o[1]||(o[1]=t=>a(e).phone=t),type:"number"},null,8,["modelValue"]),s(m,{text:"Birth Date",modelValue:a(e).birth_date,"onUpdate:modelValue":o[2]||(o[2]=t=>a(e).birth_date=t),type:"date"},null,8,["modelValue"]),s(x,{modelValue:a(e).gender,"onUpdate:modelValue":o[3]||(o[3]=t=>a(e).gender=t),text:"Gender"},{default:r(()=>[W,X]),_:1},8,["modelValue"])])]),actions:r(()=>[s(a(j),{href:p.route("dashboard.customers.index")},{default:r(()=>[s(F,null,{default:r(()=>[l(" Cancelar ")]),_:1})]),_:1},8,["href"]),s(V,{class:B({"opacity-25":a(e).processing}),disabled:a(e).processing},{default:r(()=>[l(" Guardar ")]),_:1},8,["class","disabled"])]),_:1}),s(q),s(w,{onSubmitted:y},{title:r(()=>[l(" Informacion del Plan ")]),description:r(()=>[c.customer?(n(),u(b,{key:0},[c.customer.plan?(n(),u("div",Z,[l(" El usuario tiene un plan existente, se actualizará con los datos introducidos y también se actualizará el ingreso correspondiente. "),ee,l(" Si en cambio desea crear un nuevo plan "),te,s(V,{class:"mt-4",onClick:o[4]||(o[4]=t=>p.$inertia.visit(p.route("dashboard.customers.plans.create",c.customer.id)))},{default:r(()=>[l(" Haga click aqui ")]),_:1})])):(n(),u("div",Y," El usuario no tiene un plan creado, se procederá a crear uno nuevo con los datos ingresados. "))],64)):(n(),u("div",oe," Ingrese los datos del plan para el cliente. "))]),form:r(()=>[s(x,{modelValue:a(e).service_id,"onUpdate:modelValue":o[5]||(o[5]=t=>a(e).service_id=t),text:"Service",name:"service_id"},{default:r(()=>[(n(!0),u(b,null,D(c.services,t=>(n(),u("option",{value:t.id},f(t.name),9,ae))),256))]),_:1},8,["modelValue"]),s(x,{modelValue:a(e).period,"onUpdate:modelValue":o[6]||(o[6]=t=>a(e).period=t),text:"Period"},{default:r(()=>[se,(n(!0),u(b,null,D(v.value,t=>(n(),u("option",{value:t.period},f(a(J)[t.period])+" - C$ "+f(t.value),9,re))),256))]),_:1},8,["modelValue"]),s(m,{text:"Start Date",modelValue:a(e).start_date,"onUpdate:modelValue":o[7]||(o[7]=t=>a(e).start_date=t),type:"date"},null,8,["modelValue"]),s(m,{text:"End Date",modelValue:_.value,"onUpdate:modelValue":o[8]||(o[8]=t=>_.value=t),type:"date",disabled:""},null,8,["modelValue"]),s(m,{text:"Discount",modelValue:a(e).discount,"onUpdate:modelValue":o[9]||(o[9]=t=>a(e).discount=t),type:"number"},null,8,["modelValue"]),s(m,{text:"Note",modelValue:a(e).note,"onUpdate:modelValue":o[10]||(o[10]=t=>a(e).note=t)},null,8,["modelValue"]),i("div",de,[s(K,{checked:a(e).save_note,"onUpdate:checked":o[11]||(o[11]=t=>a(e).save_note=t),text:"Guardar en notas"},null,8,["checked"])]),i("div",le," Total: C$ "+f(g.value),1)]),actions:r(()=>[s(F,{onClick:o[12]||(o[12]=t=>p.$inertia.visit(p.route("dashboard.customers.index")))},{default:r(()=>[l(" Cancelar ")]),_:1}),s(V,{class:B({"opacity-25":a(e).processing}),disabled:a(e).processing},{default:r(()=>[l(" Guardar ")]),_:1},8,["class","disabled"])]),_:1})])]),_:1}))}};export{he as default};
