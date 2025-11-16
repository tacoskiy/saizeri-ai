import Image from "next/image";

type MenuProps = {
    name: string
    price: string
    image: string
}
// 仮で入れてます
const Menu =[
    {
    image:"/menuImg.png",
    name:"ミラノ風ドリア",
    price:"273円",
    price2:"(税込305円)",
    pass:"2101"
    },
    {
    image: "/menuImg.png",
    name: "海老グラタン",
    price: "320円",
    price2:"(税込352円)",
    pass: "2102",
  },
  {
    image: "/menuImg.png",
    name: "チーズリゾット",
    price: "280円",
    price2:"(税込312円)",
    pass: "2103",
  },
]

export function ResultsBox() {
    return (
        <div className="flex flex-col items-center justify-start gap-5 p-3">
            <p className="text-3xl font-bold text-green">AIからの提案</p>
            {Menu.map((Menu, index) => (
                <div key={index} className="flex justify-start w-[452px] h-45 bg-linear-to-r from-[#ffffff33] to-[#3435411A] border-2 border-green rounded-3xl p-4 gap-4 shadow-xl shadow-green/20">
                    <Image
                        src={Menu.image}
                        alt={Menu.name}
                        width={180}
                        height={150}
                        className="rounded-3xl"
                    />
                    <div className="flex flex-col gap-5">
                        <p className="flex items-center justify-center w-18 h-12 text-white text-2xl font-bold  bg-green rounded-xl">
                            {Menu.pass
                        }</p>
                        <p className="text-2xl font-bold">{Menu.name}</p>
                        <div className="flex justify-center items-center gap-2"> 
                            <p className="text-2xl text-red-500 font-bold">{Menu.price}</p>
                            <p className="text-md font-bold text-gray-500">{Menu.price2}</p>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    )
}