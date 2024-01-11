import{_ as w}from"./AppLayout-95c26e89.js";import{_ as x}from"./PrimaryButton-cbad163b.js";import{_ as B}from"./ThePaginator-16e396d2.js";import{_ as P}from"./DialogModal-b98b38c2.js";import{_ as y}from"./InputForm-daeecd40.js";import{_ as T}from"./SecondaryButton-369c6abe.js";import{f as g,T as U,o as r,h as $,w as o,b as n,d as f,t as d,u,c as i,j,i as h,F as k,a as s}from"./app-3ea472c4.js";import{_ as A}from"./Checkbox-563248f5.js";import{t as S}from"./toast-523d5346.js";import{T as D}from"./TableSection-0dcf2228.js";import{p as q}from"./periodLabel-28cc2bc8.js";import{I as F}from"./IconPencil-0bce1737.js";import"./_plugin-vue_export-helper-c27b6911.js";const L=s("h4",{class:"font-bold text-lg mb-3"},"Precios",-1),O={key:0,class:"text-sm text-red-600 mt-1"},z=s("div",{class:"text-2xl font-extrabold text-gray-600"},"Servicios",-1),G=s("th",null,"ID",-1),M=s("th",null,"Nombre",-1),H=s("th",null,"Precios",-1),J=s("th",null,"Estado",-1),K=s("th",null,"Acciones",-1),Q={class:"hover:bg-gray-50"},R={class:"badge-blue mr-1"},W={key:0,class:"badge-success"},X={key:1,class:"badge-gray"},de={__name:"Index",props:{services:{type:Object,required:!0},periods:{type:Object,required:!0}},setup(v){const V=v,m=g(!1),p=g(!0);let _=V.periods;const C=[{name:"Inicio",route:"dashboard.index"},{name:"Servicios",route:"dashboard.services.index"}],t=U({id:null,name:"",is_active:!0,prices:[]});async function N(a){t.id=a.id,t.name=a.name,t.is_active=!!a.is_active,_.forEach(l=>{const e=a.prices.find(c=>c.period===l.period);l.value=e?e.value:null}),p.value=!1,m.value=!0}function b(){t.reset(),t.clearErrors(),_.forEach(a=>{delete a.value}),p.value=!0,m.value=!1}function E(){t.prices=_.filter(a=>a.value),p.value?t.post(route("dashboard.services.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{S.success("Servicio creado correctamente!"),b()}}):t.put(route("dashboard.services.update",t.id),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{S.success("Servicio actualizado correctamente!"),b()}})}return(a,l)=>(r(),$(w,{title:"Dashboard",breads:C},{default:o(()=>[n(P,{show:m.value},{title:o(()=>[f(d(p.value?"Nuevo":"Editar"),1)]),content:o(()=>[n(y,{text:"Nombre",name:"name",modelValue:u(t).name,"onUpdate:modelValue":l[0]||(l[0]=e=>u(t).name=e)},null,8,["modelValue"]),n(A,{checked:u(t).is_active,"onUpdate:checked":l[1]||(l[1]=e=>u(t).is_active=e),text:"Activo",class:"my-3"},null,8,["checked"]),L,a.$page.props.errors.prices?(r(),i("p",O,d(a.$page.props.errors.prices),1)):j("",!0),(r(!0),i(k,null,h(u(_),(e,c)=>(r(),$(y,{name:`prices.${c}.value`,text:e.period_label,modelValue:e.value,"onUpdate:modelValue":I=>e.value=I,type:"number"},null,8,["name","text","modelValue","onUpdate:modelValue"]))),256))]),footer:o(()=>[n(T,{onClick:b},{default:o(()=>[f(" Cancelar ")]),_:1}),n(x,{type:"button",onClick:E},{default:o(()=>[f(" Guardar ")]),_:1})]),_:1},8,["show"]),n(D,null,{topbar:o(()=>[z,n(x,{type:"button",onClick:l[2]||(l[2]=e=>m.value=!0)},{default:o(()=>[f(" Nuevo ")]),_:1})]),header:o(()=>[G,M,H,J,K]),body:o(()=>[(r(!0),i(k,null,h(v.services.data,e=>(r(),i("tr",Q,[s("td",null,d(e.id),1),s("td",null,d(e.name),1),s("td",null,[(r(!0),i(k,null,h(e.prices,c=>(r(),i("span",R,d(u(q)[c.period])+": C$ "+d(c.value),1))),256))]),s("td",null,[e.is_active?(r(),i("span",W," Activo ")):(r(),i("span",X," Inactivo "))]),s("td",null,[n(u(F),{role:"button",onClick:c=>N(e)},null,8,["onClick"])])]))),256))]),paginator:o(()=>[n(B,{links:v.services.links},null,8,["links"])]),_:1})]),_:1}))}};export{de as default};
