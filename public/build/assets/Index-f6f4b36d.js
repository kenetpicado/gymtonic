import{j as y,l as T,p as B,m as I,o as n,f as Y,w as s,b as r,d as u,a as e,c as d,k as S,F as $,s as E,x as U,h as j,O as C,t as i,u as m,i as q}from"./app-8985fe0f.js";import{C as _,_ as L}from"./AppLayout-614eddf2.js";import{_ as p}from"./PrimaryButton-c9b80bfc.js";import{_ as M}from"./ThePaginator-88d3ba92.js";import{_ as z}from"./SearchComponent-b7e4c752.js";import{_ as G}from"./Checkbox-4805c14b.js";import{_ as H}from"./DialogModal-266fc0ad.js";import{_ as J}from"./InputForm-b927c86e.js";import{_ as K}from"./SecondaryButton-f490444e.js";import{T as Q}from"./TableSection-c50dc2e9.js";import{_ as R}from"./UserInformation-8026075d.js";import{u as W}from"./notify-18e63239.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./sweetalert2.all-91b2d243.js";const X={class:"w-full border-collapse bg-white text-left text-sm text-gray-500 mt-4"},Z=e("thead",{class:"bg-gray-50"},[e("tr",null,[e("th",null,"Plan ID"),e("th",null,"Cliente"),e("th",null,"Finaliza")])],-1),ee={class:"divide-y divide-gray-100 border-t border-gray-100"},te={class:"flex items-center gap-4"},ae={class:"flex gap-2 items-center"},se=e("th",null,"Cliente",-1),re=e("th",null,"Servicio",-1),oe=e("th",null,"Periodo",-1),ne=e("th",null,"Estado",-1),le=e("th",null,"Acciones",-1),de={class:"hover:bg-gray-50"},ie={class:"flex items-center gap-2"},ce={class:"badge-blue"},ue={class:"flex items-center"},me={key:0,class:"badge-danger"},_e={key:1,class:"badge-success"},fe={key:0},he=e("td",{colspan:"5",class:"text-center"},"No data to display",-1),pe=[he],Fe={__name:"Index",props:{plans:{type:Object,required:!0}},setup(f){const g=f,v=y(!1),l=y(null),b=W(),c=y([]),D=_.today("Y-m-d"),h=T({search:"",type:"active"}),P=[{name:"Inicio",route:"dashboard.index"},{name:"Planes",route:"dashboard.plans.index"}];function w(a){h.search=a,V()}function V(){h.search===""&&delete h.search,C.get(route("dashboard.plans.index"),h,{preserveState:!0,preserveScroll:!0,only:["plans"],replace:!0})}function k(){c.value=g.plans.data.filter(a=>a.selected).map(function(a){return{id:a.id,customer:a.customer_name,end_date:a.end_date}})}const A=B(()=>g.plans.data.some(a=>a.selected));function N(){if(k(),c.value.length==0){b.error("Select at least one plan");return}v.value=!0}I(()=>l.value,a=>{k(),a&&c.value.forEach(o=>{o.end_date=_.create(o.end_date).addDays(parseInt(a)).format("Y-m-d")})});function F(){if(!l.value||l.value==0||l.value<1){b.error("Days must be greater than 0");return}C.put(route("dashboard.plans.extend"),c.value,{preserveState:!0,preserveScroll:!0,onSuccess:()=>{x(),b.success("Days added successfully")}})}function x(){l.value=null,c.value=[],v.value=!1}return(a,o)=>(n(),Y(L,{title:"Dashboard",breads:P},{default:s(()=>[r(H,{show:v.value},{title:s(()=>[u(" Agregar dias ")]),content:s(()=>[r(J,{text:"Dias",name:"days",modelValue:l.value,"onUpdate:modelValue":o[0]||(o[0]=t=>l.value=t),type:"number"},null,8,["modelValue"]),e("table",X,[Z,e("tbody",ee,[(n(!0),d($,null,S(c.value,t=>(n(),d("tr",null,[e("td",null,i(t.id),1),e("td",null,i(t.customer),1),e("td",null,i(m(_).create(t.end_date).format("d/m/Y")),1)]))),256))])])]),footer:s(()=>[r(K,{onClick:x},{default:s(()=>[u(" Cancelar ")]),_:1}),r(p,{type:"button",onClick:F},{default:s(()=>[u(" Guardar ")]),_:1})]),_:1},8,["show"]),r(Q,null,{topbar:s(()=>[e("div",te,[r(z,{onSearch:w})]),e("div",ae,[E(e("div",null,[r(p,{type:"button",onClick:o[1]||(o[1]=t=>N())},{default:s(()=>[u(" Agregar dias ")]),_:1})],512),[[U,A.value]]),r(p,{type:"button",onClick:o[2]||(o[2]=t=>a.$inertia.visit(a.route("dashboard.customers.create")))},{default:s(()=>[u(" Nuevo ")]),_:1})])]),header:s(()=>[se,re,oe,ne,le]),body:s(()=>[(n(!0),d($,null,S(f.plans.data,(t,ve)=>(n(),d("tr",de,[e("td",null,[e("div",ie,[r(G,{checked:t.selected,"onUpdate:checked":O=>t.selected=O,name:"status"},null,8,["checked","onUpdate:checked"]),r(R,{user:{name:t.customer_name}},null,8,["user"])])]),e("td",null,i(t.service_name)+" ("+i(t.period)+" dias) ",1),e("td",null,[e("div",ce,i(m(_).create(t.start_date).format("d de F"))+" - "+i(m(_).create(t.end_date).format("d de F")),1)]),e("td",null,[e("div",ue,[t.end_date==m(D)?(n(),d("span",me," Último día! ")):(n(),d("span",_e," Activo "))])]),e("td",null,[r(m(q),{href:a.route("dashboard.customers.plans.create",t.customer_id)},{default:s(()=>[r(p,null,{default:s(()=>[u(" Pagar ")]),_:1})]),_:2},1032,["href"])])]))),256)),f.plans.data.length==0?(n(),d("tr",fe,pe)):j("",!0)]),paginator:s(()=>[r(M,{links:f.plans.links},null,8,["links"])]),_:1})]),_:1}))}};export{Fe as default};