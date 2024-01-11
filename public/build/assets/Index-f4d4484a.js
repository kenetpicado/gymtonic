import{_ as F}from"./AppLayout-95c26e89.js";import{T as N}from"./TableSection-0dcf2228.js";import{_ as w}from"./SelectForm-3f762007.js";import{m as A,g as f,q as D,o as l,h as I,w as i,b as y,a as e,c as r,i as x,F as v,u as R,j as O,t as o,d as g,O as T,n as B}from"./app-3ea472c4.js";import"./_plugin-vue_export-helper-c27b6911.js";const E=e("h1",{class:"text-2xl font-extrabold text-gray-600 col-span-2"}," Resumen ",-1),P={class:"grid grid-cols-4 mb-6 gap-4"},M=e("option",{selected:"",value:""},"Todos",-1),U=["value"],z=e("option",{value:""},"Año en curso",-1),J=["value"],Y=e("th",null,"ID",-1),G=e("th",null,"Mes",-1),H=e("th",null,[g("Clientes "),e("br"),g(" registrados")],-1),K=e("th",null,[g("Planes "),e("br"),g(" contratados (aprox.)")],-1),Q=e("th",null,"Ingresos",-1),W=e("th",null,"Egresos",-1),X=e("th",null,"Ganacia",-1),Z={key:0},ee=e("td",{colspan:"7",class:"text-center"}," No hay datos para mostrar ",-1),te=[ee],oe={class:"hover:bg-gray-50"},se={class:"badge-success"},ne={class:"badge-danger"},ae={key:1,class:"bg-gray-50"},le=e("td",null,null,-1),re=e("td",{class:"font-bold"},"Total",-1),de={class:"font-bold"},ie={class:"font-bold"},ce={class:"font-bold"},ge={__name:"Index",props:{incomes:{type:Object,required:!0},expenditures:{type:Object,required:!0},concepts:{type:Object,required:!0},clients:{type:Object,required:!0},plans:{type:Object,required:!0}},setup(_){const c=_,$=[{name:"Inicio",route:"dashboard.index"},{name:"Resumen",route:"dashboard.summary.index"}],S=new URLSearchParams(window.location.search),a=A({model_id:S.get("model_id")??"",year:S.get("year")??""}),q=[{id:1,name:"Enero"},{id:2,name:"Febrero"},{id:3,name:"Marzo"},{id:4,name:"Abril"},{id:5,name:"Mayo"},{id:6,name:"Junio"},{id:7,name:"Julio"},{id:8,name:"Agosto"},{id:9,name:"Septiembre"},{id:10,name:"Octubre"},{id:11,name:"Noviembre"},{id:12,name:"Diciembre"}],C=f(()=>c.incomes.reduce((s,n)=>s+n.total,0)),V=f(()=>c.expenditures.reduce((s,n)=>s+n.total,0));D(a,j,{deep:!0});function j(){for(const s in a)a[s]===""&&delete a[s];T.get(route("dashboard.summary.index"),a,{preserveState:!0,preserveScroll:!0,only:["incomes","expenditures","clients","plans"],replace:!0})}const b=f(()=>{var n,t,u,L;const s=[];for(const m of q){const p=((n=c.incomes.find(d=>d.month===m.id))==null?void 0:n.total)??0,h=((t=c.expenditures.find(d=>d.month===m.id))==null?void 0:t.total)??0;p===0&&h===0||s.push({id:m.id,name:m.name,clients:((u=c.clients.find(d=>d.month===m.id))==null?void 0:u.total)??0,plans:((L=c.plans.find(d=>d.month===m.id))==null?void 0:L.total)??0,income:"C$ "+p.toLocaleString(),expenditure:"C$ "+h.toLocaleString(),renevue:"C$ "+(p-h).toLocaleString(),revenue_class:p-h>0?"badge-success":"badge-danger"})}return s}),k=Array.from({length:4},(s,n)=>new Date().getFullYear()-n).filter(s=>s!==new Date().getFullYear());return(s,n)=>(l(),I(F,{title:"Resumen",breads:$},{default:i(()=>[y(N,null,{topbar:i(()=>[E]),filters:i(()=>[e("div",P,[y(w,{modelValue:a.model_id,"onUpdate:modelValue":n[0]||(n[0]=t=>a.model_id=t),text:"Concepto"},{default:i(()=>[M,(l(!0),r(v,null,x(_.concepts,t=>(l(),r("option",{value:t.id},o(t.name),9,U))),256))]),_:1},8,["modelValue"]),y(w,{modelValue:a.year,"onUpdate:modelValue":n[1]||(n[1]=t=>a.year=t),text:"Año"},{default:i(()=>[z,(l(!0),r(v,null,x(R(k),t=>(l(),r("option",{value:t},o(t),9,J))),256))]),_:1},8,["modelValue"])])]),header:i(()=>[Y,G,H,K,Q,W,X]),body:i(()=>[b.value.length==0?(l(),r("tr",Z,te)):O("",!0),(l(!0),r(v,null,x(b.value,t=>(l(),r("tr",oe,[e("td",null,o(t.id),1),e("td",null,o(t.name),1),e("td",null,o(t.clients),1),e("td",null,o(t.plans),1),e("td",null,[e("span",se,o(t.income),1)]),e("td",null,[e("span",ne,o(t.expenditure),1)]),e("td",null,[e("span",{class:B(t.revenue_class)},o(t.renevue),3)])]))),256)),b.value.length>0?(l(),r("tr",ae,[le,re,e("td",null,o(_.clients.reduce((t,u)=>t+u.total,0)),1),e("td",null,o(_.plans.reduce((t,u)=>t+u.total,0)),1),e("td",de,"C$ "+o(C.value.toLocaleString()),1),e("td",ie,"C$ "+o(V.value.toLocaleString()),1),e("td",ce,"C$ "+o((C.value-V.value).toLocaleString()),1)])):O("",!0)]),_:1})]),_:1}))}};export{ge as default};
