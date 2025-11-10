"use client";

import { Header } from "@/components/Header";
import { ResultsBox } from "@/components/ResultsBox";

export default function Answer() {
    return (
        <div className="GeneralPurposeBg min-h-screen ">
            <Header/>
            <div className="flex items-center justify-center gap-4">
                <div className="flex flex-col items-center justify-center gap-4">
                    <p className="text-3xl font-bold text-green">チャット内容</p>
                    <div className="w-[617px] h-[580px] bg-white border-4 border-green rounded-3xl">

                    </div>
                </div>

                <div className="flex flex-col items-center justify-center gap-4">
                    <p className="text-3xl font-bold text-green">AIからの提案</p>
                    <ResultsBox/>
                    <ResultsBox/>
                    <ResultsBox />
                </div>
            </div>
        </div>
    )
}