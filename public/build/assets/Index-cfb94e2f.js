import{j as b,l as O,p as T,m as B,o as n,f as E,w as s,b as o,d as c,a as e,c as d,k as S,F as D,s as U,x as Y,h as L,O as $,t as u,u as m,i as M}from"./app-0d4af329.js";import{C as _,_ as j}from"./AppLayout-9b8d7803.js";import{_ as y}from"./PrimaryButton-d6170f24.js";import{_ as q}from"./ThePaginator-ed9e4943.js";import{_ as z}from"./SearchComponent-39354a67.js";import{_ as G}from"./Checkbox-229d3919.js";import{_ as H}from"./DialogModal-089b2009.js";import{_ as J}from"./InputForm-3378d3d2.js";import{_ as K}from"./SecondaryButton-28167765.js";import{T as Q}from"./TableSection-0294143f.js";import{_ as R}from"./UserInformation-5c45a6a3.js";import{u as W}from"./notify-60d3ff20.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./helpers-e7953c0e.js";import"./sweetalert2.all-d0b42def.js";const X={class:"w-full border-collapse bg-white text-left text-sm text-gray-500 mt-4"},Z=e("thead",{class:"bg-gray-50"},[e("tr",null,[e("th",null,"Plan ID"),e("th",null,"Cliente"),e("th",null,"Finaliza")])],-1),ee={class:"divide-y divide-gray-100 border-t border-gray-100"},te={class:"flex items-center gap-4"},ae={class:"flex gap-2 items-center"},se=e("th",null,"Cliente",-1),oe=e("th",null,"Servicio",-1),re=e("th",null,"Expira",-1),ne=e("th",null,"Estado",-1),le=e("th",null,"Acciones",-1),de={class:"hover:bg-gray-50"},ie={class:"flex items-center gap-4"},ce=["tooltip"],ue={class:"flex items-center"},me={key:0,class:"badge-danger"},_e={key:1,class:"badge-success"},fe={key:0},he=e("td",{colspan:"7",class:"text-center"},"No data to display",-1),pe=[he],Ie={__name:"Index",props:{plans:{type:Object,required:!0}},setup(f){const g=f,p=b(!1),l=b(null),v=W(),i=b([]),C=_.today("Y-m-d"),h=O({search:"",type:"active"}),w=[{name:"Inicio",route:"dashboard.index"},{name:"Planes",route:"dashboard.plans.index"}];function P(a){h.search=a,A()}function A(){h.search===""&&delete h.search,$.get(route("dashboard.plans.index"),h,{preserveState:!0,preserveScroll:!0,only:["plans"],replace:!0})}function k(){i.value=g.plans.data.filter(a=>a.selected).map(function(a){return{id:a.id,customer:a.customer_name,end_date:a.end_date}})}const V=T(()=>g.plans.data.some(a=>a.selected));function N(){if(k(),i.value.length==0){v.error("Select at least one plan");return}p.value=!0}B(()=>l.value,a=>{k(),a&&i.value.forEach(r=>{r.end_date=_.create(r.end_date).addDays(parseInt(a)).format("Y-m-d")})});function F(){if(!l.value||l.value==0||l.value<1){v.error("Days must be greater than 0");return}$.put(route("dashboard.plans.extend"),i.value,{preserveState:!0,preserveScroll:!0,onSuccess:()=>{x(),v.success("Days added successfully")}})}function x(){l.value=null,i.value=[],p.value=!1}return(a,r)=>(n(),E(j,{title:"Dashboard",breads:w},{default:s(()=>[o(H,{show:p.value},{title:s(()=>[c(" Agregar dias ")]),content:s(()=>[o(J,{text:"Dias",name:"days",modelValue:l.value,"onUpdate:modelValue":r[0]||(r[0]=t=>l.value=t),type:"number"},null,8,["modelValue"]),e("table",X,[Z,e("tbody",ee,[(n(!0),d(D,null,S(i.value,t=>(n(),d("tr",null,[e("td",null,u(t.id),1),e("td",null,u(t.customer),1),e("td",null,u(m(_).create(t.end_date).format("d/m/Y")),1)]))),256))])])]),footer:s(()=>[o(K,{onClick:x},{default:s(()=>[c(" Cancelar ")]),_:1}),o(y,{type:"button",onClick:F},{default:s(()=>[c(" Guardar ")]),_:1})]),_:1},8,["show"]),o(Q,null,{topbar:s(()=>[e("div",te,[o(z,{onSearch:P})]),e("div",ae,[U(e("div",null,[o(y,{type:"button",onClick:r[1]||(r[1]=t=>N())},{default:s(()=>[c(" Agregar dias ")]),_:1})],512),[[Y,V.value]]),o(y,{type:"button",onClick:r[2]||(r[2]=t=>a.$inertia.visit(a.route("dashboard.customers.create")))},{default:s(()=>[c(" Nuevo ")]),_:1})])]),header:s(()=>[se,oe,re,ne,le]),body:s(()=>[(n(!0),d(D,null,S(f.plans.data,(t,ve)=>(n(),d("tr",de,[e("td",null,[e("div",ie,[o(G,{checked:t.selected,"onUpdate:checked":I=>t.selected=I,name:"status"},null,8,["checked","onUpdate:checked"]),o(R,{user:{name:t.customer_name}},null,8,["user"])])]),e("td",null,u(t.service_name)+" ("+u(t.period)+" dias) ",1),e("td",null,[e("span",{class:"badge-blue",tooltip:m(_).create(t.end_date+" 23:59:00").diffForHumans()},u(m(_).create(t.end_date).format("d de F")),9,ce)]),e("td",null,[e("div",ue,[t.end_date==m(C)?(n(),d("span",me," ULTIMO DIA! ")):(n(),d("span",_e," Activo "))])]),e("td",null,[o(m(M),{href:a.route("dashboard.customers.plans.create",t.customer_id),class:"badge-blue"},{default:s(()=>[c(" Pagar ")]),_:2},1032,["href"])])]))),256)),f.plans.data.length==0?(n(),d("tr",fe,pe)):L("",!0)]),paginator:s(()=>[o(q,{links:f.plans.links},null,8,["links"])]),_:1})]),_:1}))}};export{Ie as default};
