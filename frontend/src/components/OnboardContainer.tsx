import Image from "next/image";

export function OnboardContainer (){
    return (
        <div className="flex flex-col items-center justify-center gap-16">
            <p className="font-bold text-4xl text-green">
                何を食べたい気分ですか？
            </p>

            
            <button className="flex items-center justify-center 
            w-[432px] h-[77px] p-6 gap-6 bg-green rounded-full 
            [box-shadow:0_0_36px_0_#44C55C_inset,0_12px_48px_0_rgba(49,160,70,0.48)]">
                <Image
                    src='MikeIcon.svg'
                    alt="マイクアイコン"
                    width={28}
                    height={28}
                />
                <p className="text-white text-2xl font-bold">話しかけてみる</p>
            </button>

            <input  type="text"  
                placeholder="または、テキストで入力"
                className="flex items-center w-[432px] h-[51px] bg-[#F4F2F1] rounded-xl 
                font-medium text-sm px-6"
            />
        </div>
    )   
}