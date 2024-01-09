import{C as k}from"./Carbon-053ffa43.js";import{_ as r}from"./CardInfo-a36f54a5.js";import{c as l,I as M,a as I,b as C,d as S,e as w,_ as D}from"./AppLayout-46e562f0.js";import{I as G}from"./IconCurrencyDollar-e43229be.js";import{o,h as g,w as N,a,c as n,i as c,F as i,t as F,u as p,b as h}from"./app-93ea45e5.js";import"./IconInfoCircle-7abc0e5f.js";var $=l("gender-female","IconGenderFemale",[["path",{d:"M12 9m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0",key:"svg-0"}],["path",{d:"M12 14v7",key:"svg-1"}],["path",{d:"M9 18h6",key:"svg-2"}]]),q=l("gender-male","IconGenderMale",[["path",{d:"M10 14m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0",key:"svg-0"}],["path",{d:"M19 5l-5.4 5.4",key:"svg-1"}],["path",{d:"M19 5h-5",key:"svg-2"}],["path",{d:"M19 5v5",key:"svg-3"}]]),L=l("gift","IconGift",[["path",{d:"M3 8m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z",key:"svg-0"}],["path",{d:"M12 8l0 13",key:"svg-1"}],["path",{d:"M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-7",key:"svg-2"}],["path",{d:"M7.5 8a2.5 2.5 0 0 1 0 -5a4.8 8 0 0 1 4.5 5a4.8 8 0 0 1 4.5 -5a2.5 2.5 0 0 1 0 5",key:"svg-3"}]]);const U={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},B=a("h1",{class:"block text-xs text-gray-500 uppercase tracking-wider font-semibold my-4"},"general",-1),O={class:"grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6"},j={class:"block text-xs text-gray-500 uppercase tracking-wider font-semibold my-4"},V={class:"grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6"},z=a("h1",{class:"block text-xs text-gray-500 uppercase tracking-wider font-semibold my-4"},"Servicios",-1),E={class:"grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6"},P={__name:"Dashboard",props:{incomes_month:{type:Number,required:!0},expenditures_month:{type:Number,required:!0},customers_count:{type:Number,required:!0},plans:{type:Object,required:!0},active_customers:{type:Object,required:!0}},setup(v){var d,m;const e=v,_=k.now().monthName(),y=[{name:"Dashboard",route:"dashboard.index"}],b=[{title:"Clientes",value:e.customers_count.toLocaleString("en-US"),icon:M},{title:"Clientes activos",value:e.plans.reduce((t,u)=>t+u.total,0),icon:I},{title:"Hombres",value:((d=e.active_customers.filter(t=>t.gender=="M")[0])==null?void 0:d.total)??0,icon:q},{title:"Mujeres",value:((m=e.active_customers.filter(t=>t.gender=="F")[0])==null?void 0:m.total)??0,icon:$}],f=[{title:"Ingresos",value:"C$ "+e.incomes_month.total.toLocaleString("en-US"),icon:C},{title:"Egresos",value:"C$ "+e.expenditures_month.toLocaleString("en-US"),icon:S},{title:"Descuentos",value:"C$ "+e.incomes_month.discount,icon:L},{title:"Ganancias",value:"C$ "+(e.incomes_month.total-e.expenditures_month).toLocaleString("en-US"),icon:G}],x=e.plans.map(t=>({title:t.service.name,value:t.total,icon:w}));return(t,u)=>(o(),g(D,{title:"Dashboard",breads:y},{default:N(()=>[a("div",U,[B,a("div",O,[(o(),n(i,null,c(b,s=>h(r,{stat:s},null,8,["stat"])),64))]),a("h1",j,"Finanzas: "+F(p(_)),1),a("div",V,[(o(),n(i,null,c(f,s=>h(r,{stat:s},null,8,["stat"])),64))]),z,a("div",E,[(o(!0),n(i,null,c(p(x),s=>(o(),g(r,{stat:s},null,8,["stat"]))),256))])])]),_:1}))}};export{P as default};
